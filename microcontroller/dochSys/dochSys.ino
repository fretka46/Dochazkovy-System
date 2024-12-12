#include <SPI.h>
#include <MFRC522.h>
#include <ESP8266WiFi.h>
#include <AsyncHTTPRequest_Generic.h>

#define openDoor D0
#define RST_PIN D1
#define SS_PIN D2
#define Buzzer D3

const char* ssid = "SPSD-B102";
const char* password = "MilujuMatematiku";
const char* serverName = "http://mujweb.spsdmasna.cz/vondra121/dochsys/web/api/verify/index.php";

long lastOpenTime = 0;

MFRC522 mfrc522(SS_PIN, RST_PIN);
AsyncHTTPRequest request;
String originalContent;

void setup() {
  Serial.begin(9600);
  SPI.begin();
  mfrc522.PCD_Init();
  Serial.println("Scan a RFID card");

  // Connect to Wi-Fi
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.println("Connecting to WiFi...");
  }
  Serial.println("Connected to WiFi");

  // Setup request callback
  request.onReadyStateChange(requestCallback);

  // Setup open door pin
  pinMode(openDoor, OUTPUT);
  digitalWrite(openDoor, LOW);
}

void loop() {
  if (millis() - lastOpenTime > 5000) {
    digitalWrite(openDoor, LOW);
  }

  // Look for new cards
  if (!mfrc522.PICC_IsNewCardPresent()) {
    return;
  }

  // Select one of the cards
  if (!mfrc522.PICC_ReadCardSerial()) {
    return;
  }

  // Show UID on serial monitor
  Serial.print("UID tag: ");
  originalContent = "";
  for (byte i = 0; i < mfrc522.uid.size; i++) {
    Serial.print(mfrc522.uid.uidByte[i] < 0x10 ? " 0" : " ");
    Serial.print(mfrc522.uid.uidByte[i], HEX);
    originalContent.concat(String(mfrc522.uid.uidByte[i] < 0x10 ? " 0" : " "));
    originalContent.concat(String(mfrc522.uid.uidByte[i], HEX));
  }
  Serial.println();

  // Send UID to server
  if (WiFi.status() == WL_CONNECTED) {
    sendPostRequest(serverName, originalContent);
  } else {
    Serial.println("WiFi Disconnected");
  }

  delay(1000);
}

void sendPostRequest(const char* url, const String& content) {
  if (request.readyState() == readyStateUnsent || request.readyState() == readyStateDone) {
    request.open("POST", url);
    request.setReqHeader("Content-Type", "application/x-www-form-urlencoded");

    // Remove empty space from the content start
    String trimmedContent = content;
    if (trimmedContent.startsWith(" ")) {
      trimmedContent.remove(0, 1);
    }

    String postData = "card_code=" + trimmedContent;
    request.send(postData);

    Serial.println("Request sent: " + postData);
  }
}

void requestCallback(void* optParm, AsyncHTTPRequest* request, int readyState) {
  if (readyState == readyStateDone) {
    Serial.print("Ready State: ");
    Serial.println(readyState);
    Serial.print("HTTP Code: ");
    Serial.println(request->responseHTTPcode());
    Serial.print("Response Text: ");
    Serial.println(request->responseText());

    if (request->responseHTTPcode() == 200) {
      Serial.println("Opening door");
      digitalWrite(openDoor, HIGH);
      lastOpenTime = millis();

      // Good beep
      tone(Buzzer, 1000);
      delay(500);
      tone(Buzzer, 1500, 500);

    } else if (request->responseHTTPcode() == 401) {
      Serial.print("Received invalid card");
      // Bad beep
      tone(Buzzer, 500);
      delay(500);
      tone(Buzzer, 250, 500);
    } else {
      Serial.println("Unknown error");

      // Error beep
      tone(Buzzer, 500, 450);
      delay(500);
      tone(Buzzer, 500, 450);
      delay(500);
      tone(Buzzer, 500, 450);
    }
  }
}