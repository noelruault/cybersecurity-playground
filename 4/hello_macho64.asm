; The following script is written for x86-64 (Mach, including MacOS X and variants)

section .data
    msg db "Hello, World!",0xa
    len equ $ - msg

section .text
    global _start

_start:
    ; Write the message to stdout (file descriptor 1)
    mov rdi, 1            ; file descriptor (stdout)
    mov rsi, msg          ; pointer to the message
    mov rdx, len          ; length of the message
    mov rax, 0x2000004    ; syscall number for sys_write (0x2000004 for macOS)
    syscall

    ; Exit the program with status code 0
    mov rdi, 0            ; exit code
    mov rax, 0x2000001    ; syscall number for sys_exit (0x2000001 for macOS)
    syscall

; nasm -hf | grep -A 21 -- '-f format'

; nasm -f macho64 2/hello_macho64.asm -o bin/hello_macho64.o
; ld -e _start -static -o bin/hello_macho64 bin/hello_macho64.o
; ./bin/hello_macho64


; objdump -a bin/hello_macho64.o
; greadelf -h bin/hello_elf64.o
; lipo -archs  bin/hello_macho64

; being implicit in setting the processor architecture:
; ld -e _start -static -arch x86_64 -o bin/hello_elf64 bin/hello_macho64.o
