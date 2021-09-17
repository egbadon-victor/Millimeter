/*
  Project "Smart Energy Meter" using current sensor arduino and GSM Module and a display
  To monitor energy consumption and cost and delelop a pre-paid system with notification and digital control of sort...
  Developed by Sakib Ahmed Sumdany & Adnan Sabbir
  November 14, 2016.
  Released into the public domain.
  Dependencies: ACS712 Library by Sakib Ahmed
*/
#include<EEPROM.h>

//Used for GSM module
#include <SoftwareSerial.h>
//SoftwareSerial Serial1(10, 11);
unsigned int temp=0,i=0,x=0,k=0;
char str[200],flag1=0,flag2=0;
String bal="";
String initSms ="AT+CMGS=\"+2348082359466\"";  //the number to send SMS
String BalanceSms = "This is an SMS from Smart Energy Meter & your balance is ";

//Used for LCD Screen
#include <Wire.h> 
#include <LiquidCrystal_I2C.h>

// Set the LCD address to 0x27 for a 16 chars and 2 line display
LiquidCrystal_I2C lcd(0x27, 16, 2);


//For current Sensor
#include "ACS712.h"
float error= 0.05;    // initial error of ACS712 sensor
 ACS712 ac1(A0, error);
double current=0L;
double power=0L;
double load=0L;
float balance=0.00f;
float unit =0.00f;
float unitPrice =5.00f;
long lastPrint = millis();
long lastDtl = millis();

///////////////////////////for relay
int relay = 8;
bool alert=true;
int pushButton = A1;
long longPressTime = 2;
int btnTime = 0;
//////////////////////////////

void setup(){

  pinMode(pushButton, INPUT);
  pinMode(relay, OUTPUT);
  lcd.begin();

  Serial.begin(9600);

  reStoreInfo();   //restore data from arduino's Static memory after reboot/ power failure
  printInfo();

  lcd.begin();
  Serial.begin(9600);

  Serial1.begin(9600);
  gsm_init();
  Serial1.println("AT+CNMI=2,2,0,0,0");
  

}

void loop(){
 
if(balance)
{
  currentCalculation();
  storeInfo();
  printDetails();
  printBalance();
  digitalWrite(relay,HIGH);
  }else{
      digitalWrite(relay,LOW);
      lcd.clear();
      lcd.print("Low Balance");
      lcd.setCursor(0,1);
      lcd.print("Please Recharge");
      delay(500);
    }
checkLowBalance();
checkSMS();
userInteraction();
ResetButton();
Serial.flush();
Serial1.flush();

}

void ResetButton()
{
//if(digitalRead(pushButton)==0)  
//  Serial.println("Reseting");
if(digitalRead(pushButton)==1)
 {
  btnTime = millis()/1000;
  while(digitalRead(pushButton))
  {
//    Serial.println("Reseting");
      lcd.clear();
      lcd.println("Reseting");

    if((millis()/1000)-btnTime>(longPressTime-1))
    {
        
        lcd.clear();
        lcd.println("Reset Done");
        delay(1000);
        balance=00.00f;
        unit=00.00f;
        for (int i = 0 ; i < EEPROM.length() ; i++) EEPROM.write(i, 0);    //clear all EEPROM
        storeInfo();
        printInfo();
        alert=true;
        
      break;
      }
    }
  }   
}
  
void userInteraction()
{
  if (Serial.available()>0)
    {
      char cmd = Serial.read();
      Serial.println(cmd); 
      
      if(cmd=='R') 
      {
        balance=00.00f;
        unit=00.00f;
        for (int i = 0 ; i < EEPROM.length() ; i++) EEPROM.write(i, 0);    //clear all EEPROM
        storeInfo();
        printInfo();
      }            
  
      if(cmd=='U') {
        balance+=1000.00f;
        printInfo();
        alert = true;
        
        }
      if(cmd=='G') {
        unit+=10.00f;
        printInfo();
      
      }
  
  
      
      Serial.flush();
   }
  }


void checkLowBalance()
{
  if(balance < 20 && alert)     //notify customer about low balance
  {
      sendSms("Your Balance is Below 20NGN, Please recharge to avoid disconnection");
      alert = false;
  }
}

void printBalance()
{
  if((millis() - lastPrint)>5000) //print balance and usage every 5 seconds without using delay()
    {
      printInfo();
      lastPrint = millis();
    }
  }

void currentCalculation()
{
   current = ac1.getACcurrent();   //power calculations
   power=
   load =(power/(1000.0L*3600.0L)); // instantanious load
   unit+=load;                      //Cumulated load or power consumption 
   balance -=load*unitPrice;        // balance adjustment  
  }

//printing...
void printInfo()
{
  Serial.print("\n\tBalance left:  ");
  Serial.print(balance,4);
  Serial.print("NGN Total Use: ");
  Serial.print(unit,5);
  Serial.println(" Units\n");

  lcd.clear();
  lcd.print("Balance:");
  lcd.print(balance,2);
  lcd.print("NGN");
  lcd.setCursor(0,1); 
  lcd.print("Use:");
  lcd.print(unit,4);
  lcd.print(" KWtt");
  delay(100);
}
void printDetails()
{
     Serial.print("\t");
     Serial.print(current);
     Serial.print(" Amps, ");
      Serial.print(power);
     Serial.print(" Watt,   ");
      Serial.print(unit,5);
     Serial.println(" KWatt-hour\t");


  lcd.clear();
  lcd.print("Current:");
  lcd.print(current,3);
  lcd.print("Amps");
  lcd.setCursor(0,1); 
  lcd.print("Power:");
  lcd.print(power);
  lcd.print(" Watt");

  
  }

//eeprom functions
void storeInfo()
{
//  EEPROM[100]=unit;
//  EEPROM[0]=balance;
    
  EEPROM.put(0,unit);
  EEPROM.put(100,balance);
  

  
}

void reStoreInfo()
{
//  unit= EEPROM[100];
//  balance= EEPROM[0];
    
  EEPROM.get(0,unit);
  EEPROM.get(100,balance);
  
}

/////////////////////////////////////////////////
//All the methods for GSM and SMS System
/////////////////////////////////////////////////
void gsm_init()
{
  lcd.clear();
  lcd.print("Finding Module..");
  Serial.println("Finding Module..");
  boolean at_flag=1;
  while(at_flag)
  {
    Serial1.println("AT");
    while(Serial1.available()>0)
    {
      if(Serial1.find("OK"))
      at_flag=0;
    }
    delay(1000);
  }
  lcd.clear();
  lcd.print("Module Connected..");
  Serial.println("Module Connected..");
  delay(1000);
  lcd.clear();
  lcd.print("Disabling ECHO");
  Serial.print("Disabling ECHO");
  boolean echo_flag=1;
  while(echo_flag)
  {
    Serial1.println("ATE0");
    while(Serial1.available()>0)
    {
      if(Serial1.find("OK"))
      echo_flag=0;
    }
    delay(1000);
  }
  lcd.clear();
  lcd.print("Echo OFF");
  Serial.print("\tEcho OFF");
  delay(1000);
  lcd.clear();
  lcd.print("Finding Network..");
  Serial.println("\t Finding Network..");
  boolean net_flag=1;
  while(net_flag)
  {
    Serial1.println("AT+CPIN?");
    while(Serial1.available()>0)
    {
      if(Serial1.find("+CPIN: READY"))
      net_flag=0;
    }
    delay(1000);
  }
  lcd.clear();
  lcd.print("Network Found..");
  Serial.println("Network Found..");
  delay(1000);
  lcd.clear();
}

void sendSms(String text){

  init_sms();
  Serial.println("Sending:");
  send_data(text);
  send_sms();
}

void init_sms()
{
   Serial1.println("AT+CMGF=1");
   delay(200);
   Serial1.println(initSms);
   
   delay(200);
}

void send_sms()
{
  Serial1.write(26);
  message_sent();
}

void send_data(String message)
{
  Serial1.println(message);
  Serial.println(message);
  delay(200);
}

void message_sent()
{
  lcd.clear();
  lcd.print("Message Sent.");
  Serial.println("Message Sent.");
  delay(1000);
  //Serial1.flush();
}

void checkSMS(){
    Serial1Event();
    balanceCheck();
      if(temp==1)
      {
       decode_message();
       send_confirmation_sms();
      }
  }

void Serial1Event()
{
  while(Serial1.available())
  {
    char ch=(char)Serial1.read();
      str[i++]=ch;
    
    if(ch == '*')
    {
      temp=1;
      lcd.clear();
      lcd.print("Message Received");
      Serial.print("Message Received:\t");
//      Serial.println(str);
      delay(500);
      break;
    }
  }
}

void decode_message()
{
    x=0,k=0,temp=0;
    while(str[x]!='#')
    {
      x++;
     }
      x++;
      bal="";
      while(str[x]!='*')
      {
        bal+=str[x];
        x++;
        }
        Serial.println(bal.toInt());
      
}

void send_confirmation_sms()
{
    int recharge_amount=bal.toInt();
    balance+=recharge_amount;
    lcd.clear();
    lcd.print("Energy Meter ");
    lcd.setCursor(0,1);
    lcd.print("Recharged:");
    lcd.print(recharge_amount);
    delay(2000);
    String text1="Energy meter recharged NGN:";
    text1+=recharge_amount;
    String text2= text1+". Total Balance "+(String)balance;
    sendSms(text2);
    Serial.print(    "           SENT:"  );
    Serial.print(text1);
    Serial.println(text2);
    temp=0;
    i=0;
    x=0;
    k=0;
    delay(1000);
}

void balanceCheck(){
    
    x=0,k=0;
    String Stringcheck = "";
    while(x<i)
    {
      Stringcheck+=str[x];
      x++;
      }
//      Serial.println("Checking");
//      Serial.println(Stringcheck);
      if(Stringcheck.indexOf("Balance?")>0)
      {
        sendSms("Total Balance "+(String)balance);
        for(int c=0;c<i;c++)
        {
            str[c]='a';
          }
        }
  }








  
