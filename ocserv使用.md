### 环境
阿里云服务器+centos6.8

### 步骤
0. yum install epel-release
1. 使用yum install ocserv安装服务
2. 修改配置文件/etc/ocserv/ocserv.conf,配置验证方式，分配ip地址
3. 重启服务service ocserv start
4. 配置防火墙 /etc/sysconfig/iptables
5. 启动防火墙 service iptables start
6. 添加路由转发，将/etc/sysctl.conf中的net.ipv4.ip_forward值改为1
7. 上面那个是内核设置，要让它立即生效，执行命令sysctl -p
8. 阿里云控制台增加安全组规则  
9. 开启ocserv服务  ocserv -c /etc/ocserv/ocserv.conf -f -d 1
10. 设置开机自启 `systemctl enable ocserv && systemctl start ocserv`
 

### 生成证书

- 创建工作文件夹  
```
$ mkdir CA
 
$ cd CA
```
- 生成CA证书  
```
$ certtool --generate-privkey --outfile ca-key.pem
$ cat >ca.tmpl <<EOF
cn = "VPN CA"
organization = "Big Corp"
serial = 1
expiration_days = 3650
ca
signing_key
cert_signing_key
crl_signing_key
EOF
 
$ certtool --generate-self-signed --load-privkey ca-key.pem --template ca.tmpl --outfile ca-cert.pem
```

- 生成本地服务器证书  
```
$ certtool --generate-privkey --outfile server-key.pem
$ cat >server.tmpl <<EOF
cn = " 
organization = "MyCompany"
serial = 2
expiration_days = 3650
encryption_key
signing_key
tls_www_server
EOF
 
$ certtool --generate-certificate --load-privkey server-key.pem --load-ca-certificate ca-cert.pem --load-ca-privkey ca-key.pem --template server.tmpl --outfile server-cert.pem

```

### 管理
1. 用户保存在/etc/ocserv/ocpasswd
2. 创建用户 ocpasswd -c /etc/ocserv/ocpasswd username
3. /etc/ocserv/ocpasswd 用户名，输入两次密码，不用重启服务

## 参考：  
[搭建ocserv VPN使IOS访问外国常用网站](http://www.itts-union.com/2155.html)
