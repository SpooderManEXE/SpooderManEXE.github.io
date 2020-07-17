---
title: Raspberry Pi Polaroid Camera
thumbnail: thumb.jpg
---
# Raspberry Pi Polaroid Camera
Polaroids are great, but if you want to make your own weird version, this guide helps you link up a Raspberry Pi and camera to a thermal printer.

The project uses a Raspberry Pi, camera module, thermal printer, battery, and few other switches and buttons. Once everything is assembled, you can instantly snap and print pictures. They’re cute and black & white, but that’s all part of the appeal.


Welcome to [Hexo](https://hexo.io/)! This is your very first post. Check [documentation](https://hexo.io/docs/) for more info. If you get any problems when using Hexo, you can find the answer in [troubleshooting](https://hexo.io/docs/troubleshooting.html) or you can ask me on [GitHub](https://github.com/hexojs/hexo/issues).

## Parts required:

{% blockquote %}
• Raspberry Pi B+ : https://u.nu/1tv8x
• Any Camera board : (example: https://u.nu/pon2-)
• Nano TTL thermal printer : (https://u.nu/4lqkc)
• Momentary Push Button (2) : (https://u.nu/t57vo)
• Perma Proto HAT — No EEPROM (for better connectivity): (https://u.nu/nign8)
• Thermal Paper Rolls (https://u.nu/ypq06)
• MicroSD Card
• Rechargeable NiMH batteries (4) and case with charger / Powerbank
{% endblockquote %}


## System Setup:
### Basic Setup:
Download the latest version of Raspbian Lite if you haven’t already. You do not need the regular full version; “Lite” is adequate for this project’s needs and can fit on a 2GB card with room to spare. You’ll also need a keyboard and monitor attached, and a Ethernet adapter.

{% blockquote %}
Download the lite version from https://www.raspberrypi.org/downloads/raspberry-pi-os/
{% endblockquote %}

Write the OS to an 2GB or larger SD card, insert in the Raspberry Pi and power it up. After a minute or so you’ll get a login prompt. Log in with the usual default pi/raspberry user and password.

{% blockquote %}
user: pi
password: raspberry
{% endblockquote %}

Then run the raspi-config utility:
``` bash
sudo raspi-config
```
The following options are required:
{% blockquote %}
• Under “Advanced Options”, expand Filesystem.
• Under “Interfacing Options”, select “Camera” and enable the camera.
• Under “Interfacing Options”, select “Serial” and disable the serial console.
{% endblockquote %}

When you’re done, tab over to the button and reboot the system when prompted. Log in as the “pi” user again.


### Install Software:
First we need to install printer support (CUPS — the Common UNIX Printing System) and some related development tools.
``` bash
sudo apt-get update
sudo apt-get install git cups wiringpi build-essential libcups2-dev libcupsimage2-dev
```
Then install the raster filter for CUPS. This processes bitmap images into the thermal printer’s native format.
``` bash
cd
git clone https://github.com/adafruit/zj-58
cd zj-58
make
sudo ./install
```
The thermal printer may have arrived with a test page in the box or the paper bay. If not, or if you threw that away, you can generate a new one by installing a roll of paper and holding the feed button (on printers that have one) while connecting power, or tapping the button on the back of the “Nano” printer or the “Printer Guts.”

{% asset_img img1.jpg baud ( reference: https://learn.adafruit.com/assets/32197 ) %}

Look for the baud rate that’s printed near the bottom of the page. This is typically either 9600 or 19200 baud. This is important. You’ll need to know the correct value for your printer.

To add the printer to the CUPS system and set it as the default, we’ll be typing two lines similar to the following.
``` bash
sudo lpadmin -p ZJ-58 -E -v serial:/dev/ttyAMA0?baud=9600 -m zjiang/ZJ-58.ppd
sudo lpoptions -d ZJ-58
```
On the first line, change the “baud” value to 9600 or 19200 as required for your printer.

### Camera Script:
The code that handles the shutter button and moves images from the Pi camera to the printer is included with the version of the CUPS filter software. You’ll find it in /home/pi/zj-58/extras/camera.sh
```bash
#!/bin/bash

SHUTTER=16
HALT=21
LED=5

# Initialize GPIO states
gpio -g mode  $SHUTTER up
gpio -g mode  $HALT    up
gpio -g mode  $LED     out

# Flash LED on startup to indicate ready state
for i in `seq 1 5`;
do
	gpio -g write $LED 1
	sleep 0.2
	gpio -g write $LED 0
	sleep 0.2
done

while :
do
	# Check for shutter button
	if [ $(gpio -g read $SHUTTER) -eq 0 ]; then
		gpio -g write $LED 1
		raspistill -n -t 200 -w 512 -h 384 -o - | lp

		sleep 1
		# Wait for user to release button before resuming
		while [ $(gpio -g read $SHUTTER) -eq 0 ]; do continue; done
		gpio -g write $LED 0
	fi

	# Check for halt button
	if [ $(gpio -g read $HALT) -eq 0 ]; then
		# Must be held for 2+ seconds before shutdown is run...
		starttime=$(date +%s)
		while [ $(gpio -g read $HALT) -eq 0 ]; do
			if [ $(($(date +%s)-starttime)) -ge 2 ]; then
				gpio -g write $LED 1
				shutdown -h now
			fi
		done
	fi
done
```
### Configure for Auto-Start:
We need to make the camera script launch automatically when the system boots.
```bash
sudo nano /etc/rc.local
```
Before the final “exit 0” line, insert:
```bash
sh /home/pi/zj-58/extras/camera.sh
```
{% asset_img img2.jpg rc.local ( reference: https://learn.adafruit.com/assets/32317 ) %}

Save the changes to the file and exit the editor.

{% blockquote %}
Once the system is fully configured, you may want to back up the SD card. Like any battery-operated Pi project, there is a small possibility of the filesystem getting corrupted. Many utilities that write SD card images can also read a card to create a backup.
{% endblockquote %}

## Connections:
{% asset_img img3.jpg Pinout %}







Reference: [Adafruit](https://learn.adafruit.com/instant-camera-using-raspberry-pi-and-thermal-printer)
