; The following script is written for x86-64 (Linux, most Unix variants)

section .data                  ; section declaration
    msg db "Hello, World!",0xa ; our string with a carriage return
    len equ $ - msg            ; length of our string, $ means here

section .text                   ; mandatory section declaration
    global _start               ; export the entry point to the ELF linker or loaders conventionally recognize _start as their entry point

_start:
                                ; now, write our string to stdout
                                ; notice how arguments are loaded in reverse
    mov     rdx,len             ; third argument (message length)
    mov     rcx,msg             ; second argument (pointer to message to write)
    mov     rbx,1               ; load first argument (file handle (stdout))
    mov     rax,4               ; system call number (4=sys_write)
    int     0x80                ; call kernel interrupt and exit
    mov     rbx,0               ; load first syscall argument (exit code)
    mov     rax,1               ; system call number (1=sys_exit)
    int     0x80                ; call kernel interrupt and exit

; nasm -hf | grep -A 21 -- '-f format'

; nasm -f elf64 2/hello_elf64.asm -o bin/hello_elf64.o
; ld --strip-all -o bin/hello_elf64 bin/hello_elf64.o
; ./bin/hello_elf64

; objdump -a bin/hello_elf64.o
; readelf -h bin/hello_elf64.o

; being implicit in setting the processor architecture:
; ld --strip-all -A x86_64 -o bin/hello_elf64 bin/hello_elf64.o
