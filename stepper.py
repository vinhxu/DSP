import os
import sys
import serial
import datetime
import time
import RPi.GPIO as GPIO
import threading
import math
import subprocess

stepPin = 		20
directionPin = 	21

GPIO.setmode(GPIO.BCM)
GPIO.setup(stepPin, GPIO.OUT)
GPIO.setup(directionPin, GPIO.OUT)
GPIO.output(directionPin, GPIO.HIGH)

def step(numberOfSteps,delayTime):
	for i in range (0,numberOfSteps):
		GPIO.output(stepPin, GPIO.HIGH)
		time.sleep(delayTime)
		GPIO.output(stepPin, GPIO.LOW)

def record(currentRPM):
	t = datetime.datetime.now()
	os.system("sudo python arecord.py %s" %currentRPM)



if (len(sys.argv)==2):
	RPM = sys.argv[1]
	#1/4 step mode
	t = threading.Thread(target=record, args=("current",))
	t.start()
	delayTime = 1/(float(RPM)/60*200*4)
	startTime = time.time()
	step(200*4,delayTime)
	endTime = time.time()
	print "Length of arguments: " +str(len(sys.argv))
	print "demanded RPM: " + str(RPM)
	print "measured RPM: " + str(60/(endTime-startTime))
	print "delay: " + str(delayTime)
	print " "
	print " "
	os.system("sudo ./stop.sh")
	time.sleep(1)
	batcmd="cd /usr/share/octave/packages/general-1.3.4 && ./test.m /var/www/files/sound.wav"
	result = subprocess.check_output(batcmd, shell=True)
	index = result.find("ans =", 0, len(result))
	freq = result[index+5:len(result)].lstrip()

	print "Fundamental frequency:   " + freq
	print "Calculated RPM:   " +str(float(freq)/(200/60.0))

elif(len(sys.argv)==4):
	#debug
	print "Length of arguments: " +str(len(sys.argv))	
	lowerLimitRPM=int(sys.argv[1])
	upperLimitRPM=int(sys.argv[2])
	incrementRPM=int(sys.argv[3])
	currentRPM=lowerLimitRPM
	
	print "upperLimitRPM: " + str(upperLimitRPM)
	print "lowerLimitRPM: " + str(lowerLimitRPM)
	print "incrementRPM: "  + str(incrementRPM)
	print "currentRPM: "	+ str(currentRPM)
	print " "

	while(currentRPM<upperLimitRPM):
		t = threading.Thread(target=record, args=(currentRPM,))
		t.start()
		delayTime = 1/(float(currentRPM)/60*200*4)
		#delayTime = 0.009333892994*math.exp(-0.03979023896*currentRPM)
		time.sleep(1)
		startTime = time.time()
		step(200*4,delayTime)
		endTime = time.time()
		time.sleep(1)
		print "demanded RPM: " + str(currentRPM)
		print "measured RPM: " + str(60/(endTime-startTime))
		print "delay: " + str(delayTime)
		print " "
		print " "
		currentRPM=currentRPM+incrementRPM
		os.system("sudo ./stop.sh")
		time.sleep(1)
		
	else:
		currentRPM=upperLimitRPM
		t = threading.Thread(target=record, args=(currentRPM,))
		t.start()
		delayTime = 1/(float(currentRPM)/60*200*4)
		#delayTime = 0.009333892994*math.exp(-0.03979023896*currentRPM)
		startTime = time.time()
		step(200*4,delayTime)
		endTime = time.time()
		print "demanded RPM: " + str(currentRPM)
		print "measured RPM: " + str(60/(endTime-startTime))
		print "delay: " + str(delayTime)
		print " "
		print " "
		os.system("sudo ./stop.sh")
		time.sleep(1)
#for debug

#for power regression
# x		    Y
# 9.5939   .0075
# 18.5749  .00375
# 27.3028  .0025
# 35.4252  .001875
# 43.1555  .0015
# 50.0336  .00125
# 56.4949  .00107
# 62.6449  .0009375
# 60.9268  .000833
# 72.8815  .00075


GPIO.cleanup()


