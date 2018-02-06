//--------------------------------------Dodatkowe pliki bibliotek do komunikacji i2c, obsługi czujnika temperatury, wyświetlacza oraz płytki do połączenia z Internetem
#include <OneWire.h>                                                              //biblioteka do obsługi OneWire 
#include <DallasTemperature.h>                                                    //biblioteka do obsługi DS18B20
#include <Wire.h>                                                                 //biblioteka do obsługi biblioteki i2c
#include "cactus_io_BME280_I2C.h"                                                 //biblioteka do obsługi czujnika temperatury
#include <ESP8266WiFi.h>       
#include <ESP8266HTTPClient.h>                                    //biblioteka do obsługi karty ESP8266 - kontrolera sieci wifi
//--------------------------------------Inicjowanie obiektów i zmiennych globalnych
BME280_I2C BME280(0x76);                                             // stworzenie nową instancję obiektu BME280_I2C, przypisanie nazwy i ustalenie adres komunikacji i2c na 0x76
OneWire oneWire(D2);                                                //ustawienie portu w urządzeniu jako portu do komunikacji z magistralą OneWire
DallasTemperature sensors(&oneWire);                                //przekazanie referencji do wybranej szyny OneWire

const char *nazwasieci = "StacjaPogodowa";                                        //nazwa sieci rozgłaszanej przez urządzenie, umożliwiająca połączenie się ze stacją
const char *haslowifi = "PogodowaStacja";                                         //puste hasło oznacza sieć otwartą, do której może podłączyć się każde urządzenie 
const char* host = "192.168.4.1";
int cisnienie = 0;
int wilgotnosc =0;
double temperatura = 0;
int czujniktype = 2;                                                //1 for BME280, 2 for DS18B20, 3 for DHT11/DHT22
int serialnumber= 3;
int BME280Connected=0;
int DS18B20Connected=0;
int DHT22Connected=0;

//przygotowanie funkcji do uruchomienia
void odczytaj_wartosci_BME280();
void odczytaj_wartosci_DS18B20();
void setup()                                                                      //kod programu który wykona się tylko raz - przy uruchomieniu urządzenia
{
Serial.begin(115200);                                                               //nawiązanie komunikacji z portem szeregowym(dla celów debugowania) z prędkością transmisji 9600 baudów na sekundę
Serial.println("ZintegrowanySystemMonitoringuPogody (c) 2016-2017 Arkadiusz Kozuch");               //Wyświetlenie w terminalu informację o stacji pogodowej

if(!BME280.begin())                                                  //sprawdzenie poprawności działania czujnika temperatury i wyświetlenie komunikatu o błędzie w przypadku jej braku
{
  BMEConnected=0;
  }
else 
{
  BMEConnected=1;
}




delay(10000);
}
void odczytaj_wartosci_DS18B20()
{
      sensors.requestTemperatures(); // Wyślij prośbę o pobranie danych z czujnika na szynie OneWire
      temperatura=sensors.getTempCByIndex(0)); // pobierz temperaturę z pierwszego czujnika na szynie OneWire 
}


void odczytaj_wartosci_BME280()
{if (BME280Connected)
  {
    BME280.readSensor(); 
    cisnienie = BME280.getPressure_MB();
    wilgotnosc = BME280.getHumidity();
    temperatura = BME280.getTemperature_C();
  }
}

void podlaczdoWifi()
{
   WiFi.mode(WIFI_STA);
  WiFi.begin(nazwasieci, haslowifi);
  
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }

  Serial.println("");
  Serial.println("WiFi connected");  
  Serial.println("IP address: ");
  Serial.println(WiFi.localIP());
}

void loop() //ten kod będzie wykonywał się w pętli w trakcie działania urządzenia
{
odczytaj_wartosci_DS18B20();
odczytaj_wartosci_BME280();
HTTPClient client;
client.begin("http://192.168.4.1/addtodb.php");
client.addHeader("Content-Type", "application/x-www-form-urlencoded", false, true);
int httpCode = client.POST("temp="+(String)temperatura+"&pres="+cisnienie+"&humi="+wilgotnosc+"&seid="+serialnumber);
 if(httpCode > 0) {
            // HTTP header has been send and Server response header has been handled
            Serial.printf("[HTTP] POST... code: %d\n", httpCode);

            // file found at server
            if(httpCode == HTTP_CODE_OK) {
                String payload = client.getString();
                Serial.println(payload);
  client.end();}}
  delay(300000);
}
