# led-control

Little project to activate pins via a Docker container on a Raspberry Pi with hypriot(http://blog.hypriot.com/).

# Install
## Download
Download the current version
<pre>
git clone https://github.com/legionth/led-control.git
</pre>
(or download the project)

## Install on your Raspberry Pi
Just put the whole project on your Raspberry Pi with hypriot. e.g. scp
<pre>
scp -r /workspace/led-control root@raspberry-pi:working-directory
</pre>

Create a docker container on your Raspberry Pi
<pre>
docker build -t led-control .
</pre>

Start the container:
<pre>
docker run --device /dev/ttyAMA0:/dev/ttyAMA0 --device /dev/mem:/dev/mem -v `pwd`:/var/www --privileged -p 80:80 -it led-control
</pre>

