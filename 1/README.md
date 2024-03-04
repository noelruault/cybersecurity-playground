# 3 - Equipo Azul, Rojo y Morado

La práctica de hoy se presenta con un contenedor que contiene un servidor dockerizado (https://github.com/noelruault/cybersecurity-playground/tree/main/1).

1. Encender contenedor

```bash
docker build . -t phpserver
docker run -it -p 80:80 phpserver
```

2. Comprobar que puertos estan abiertos

Idealmente, en una máquina remota, ejecutaríamos un nmap hacia una dirección IP y obtendríamos los puertos disponibles de forma "limpia", debido a la complejidad del sistema de red de docker, aun extrayendo la IP del contenedor y haciendo un nmap directamente, no obtendríamos los resultados esperados:

``` bash
docker network ls

# Id of container can be obtained using `docker ps` or the next command
container_id=$( \
    docker ps | grep phpserver | awk '{print $1}' \
) \
&& [ -n "$container_id" ] \
&& echo "$container_id" \
|| echo "Container not found"

docker container inspect $container_id | IPv4Address
```

```txt
Starting Nmap 7.94 ( https://nmap.org ) at 2024-02-28 12:10 CET
Note: Host seems down. If it is really up, but blocking our ping probes, try -Pn
Nmap done: 1 IP address (0 hosts up) scanned in 3.05 seconds
```

Por lo tanto, lo más fácil en este caso es hacer un `nmap -p- localhost -v` antes y después de iniciar el contenedor (`docker run`) y ver qué cambios hay en los puertos del host, para comprobar si alguno de los puertos que ejecuta el contenedor está en uso y/o es accesible.

3. Una vez accedas al servidor, descubre cómo acceder a la página de subidas, que te permitirá subir ficheros al servidor.
4. Desde el host: Sube un fichero al servidor que permita una reverse shell (https://github.com/noelruault/cybersecurity-playground/blob/main/1/shells/rshell.php). Existen alternativas más extendidas como [pentestmonkey](https://github.com/pentestmonkey/php-reverse-shell) y [p0wny-shell](https://github.com/flozz/p0wny-shell).
5. Encontrarás un error, falta un directorio en el sistema, probablemente eliminado cuando se eliminó la funcionalidad de subidas, pero puedes solucionar dicho problema usando la funcionalidad de "Remote Code Execution".
6. host: Ejecuta el comando netcat que esperará una conexión desde el objetivo
    - `nc.exe -l -p 1234` | `ncat -l -p 1234` |   `nc -l -p 1234`
7. host: Encontrar donde se ha subido el fichero en el servidor web y
8. host: Ejecutarlo desde el navegador
9. Hacer una captura de pantalla de que la reverse shell ha sido ejecutada.

# Tareas

10. Escala privilegios y obtén la contraseña de root.

    - Ayúdate de [HackTricks - Linux Privilege Escalation](https://book.hacktricks.xyz/linux-hardening/privilege-escalation)

11. Realiza el trabajo de los equipos Azul y Rojo:

- Parte 1 (Equipo Rojo): Detalla los pasos siguiendo la metodología MITRE ATT&CK para facilitar la mitigación de un posible ataque con el informe resultante.
- Parte 2 (Equipo Azul): Elabora un informe de mitigaciones basado en el primer informe para prevenir la repetición de los eventos descritos.

## Referencias

- https://github.coventry.ac.uk/pages/CUEH/245CT/essentials/DockerGuide
- https://medium.com/@mat.redzia/php-reverse-shell-breaking-into-a-vulnerable-machine-tryhackme-write-up-824351a44675
- https://blog.g0tmi1k.com/2011/08/basic-linux-privilege-escalation/
- https://www.revshells.com
- https://jeanfrancoismaes.github.io/work-adventures/penetration-testing/pwningdockervm/
- https://gtfobins.github.io
- https://payatu.com/blog/a-guide-to-linux-privilege-escalation/
- https://tryhackme.com/r/room/linprivesc
