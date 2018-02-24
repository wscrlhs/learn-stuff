### 环境
阿里云服务器+centos6.8

### 步骤
1. 使用yum install ocserv安装服务
2. 修改配置文件/etc/ocserv/ocserv.conf,配置验证方式，分配ip地址
3. 重启服务service ocserv start
4. 配置防火墙 /etc/sysconfig/iptables
5. 启动防火墙 service iptables start
6. 添加路由转发，将/etc/sysctl.conf中的net.ipv4.ip_forward值改为1
7. 上面那个是内核设置，要让它立即生效，执行命令sysctl -p
8. 阿里云控制台增加安全组规则

### 管理
1. 用户保存在/etc/ocserv/ocpasswd
2. 创建用户 ocpasswd -c /etc/ocserv/ocpasswd test
3. /etc/ocserv/ocpasswd 用户名，输入两次密码，不用重启服务
