# 3 - Equipo Azul, Rojo y Morado

La práctica de hoy se presenta con un contenedor que contiene un servidor dockerizado.

1. Encender contenedor

```bash
docker build . -t phpserver
docker run -it -p 80:80 phpserver
```

2. Comprobar que puertos estan abiertos

    1. Idealmente, en una máquina remota, ejecutaríamos un nmap hacia una dirección IP y obtendríamos los puertos disponibles de forma "limpia", debido a la complejidad del sistema de red de docker, aun extrayendo la IP del contenedor y haciendo un nmap directamente, no obtendríamos los resultados esperados:

``` bash
        docker network ls

        # Id of container can be obtained using `docker ps` or the next command	
        container_id=$( \
            docker ps | grep phpserver | awk '{print $1}' \
        ) \
        && [ -n "$container_id" ] \
        && echo "$container_id" \
        || echo "Container not found"

        docker container inspect <container_id> | IPv4Address
```

```txt
Starting Nmap 7.94 ( https://nmap.org ) at 2024-02-28 12:10 CET
Note: Host seems down. If it is really up, but blocking our ping probes, try -Pn
Nmap done: 1 IP address (0 hosts up) scanned in 3.05 seconds
```

1. Por lo tanto, lo más fácil en este caso es hacer un `nmap -p- localhost -v` antes y después de inicial el contenedor (`docker run`) y ver qué cambios hay en los puertos del host, para comprobar si alguno de los puertos que ejecuta el contenedor está en uso y/o es accesible.
2. Una vez accedas al servidor, descubre cómo acceder a la página de subidas, que te permitirá subir ficheros al servidor.
3. Desde el host: Sube un fichero al servidor que permita una reverse shell ().
4. host: Ejecuta el comando netcat que esperará una conexión desde el objetivo 
    - `nc.exe -l -p 1234` | `ncat -l -p 1234` |   `nc -l -p 1234`
5. host: Encontrar donde se ha subido el fichero en el servidor web y
6. host: Ejecutarlo desde el navegador
7. Hacer una captura de pantalla de que la reverse shell ha sido ejecutada.
8. Escala privilegios y obtén la contraseña de root.
    - https://book.hacktricks.xyz/linux-hardening/privilege-escalation

Parte 1: Mapea a Attack los pasos que has seguido de manera que un Blue Team pueda mitigar un posible ataque.
Parte 2: Haz un informe de mitigaciones basado en tu primer informe, que pueda llevarse a cabo para evitar que lo escrito en el informe vuelva a pasar.

## Referencias

- https://github.coventry.ac.uk/pages/CUEH/245CT/essentials/DockerGuide
- https://medium.com/@mat.redzia/php-reverse-shell-breaking-into-a-vulnerable-machine-tryhackme-write-up-824351a44675
- https://blog.g0tmi1k.com/2011/08/basic-linux-privilege-escalation/
- https://www.revshells.com
- https://jeanfrancoismaes.github.io/work-adventures/penetration-testing/pwningdockervm/
