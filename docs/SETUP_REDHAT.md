# Detailed Guide: Red Hat VM (Server) Setup and Hardening

The Red Hat VM is the **Exam Server** and the **Security Gateway**. Its configuration is critical for the entire system's security.

## 1. Static IP Configuration (Crucial)

You mentioned you have set a static IP, but it must be done correctly and consistently.

| Parameter | Recommended Value | Why it Matters |
| :--- | :--- | :--- |
| **IP Address** | `192.168.1.1` | This will be the fixed address for the exam server and the DNS server. All student machines will point to this. |
| **Subnet Mask** | `255.255.255.0` | Standard for a small local network. |
| **Gateway** | (Leave Blank or Set to Router IP) | If the VM is *only* serving the exam, it doesn't need a gateway. If it needs to access the internet for updates, set it to your 4G router's IP. **Crucially, the student hosts will NOT use this gateway.** |
| **DNS Server** | `127.0.0.1` | The VM will host its own DNS server (Dnsmasq) to handle local requests. |

### ⚠️ Gotcha: Network Manager
If you use a GUI tool like NetworkManager, ensure the connection is set to **"Manual"** or **"Static"** and not DHCP. A changing IP will break the student host configurations.

## 2. Web Stack Installation (Nginx, PHP-FPM)

We will use Nginx as a reverse proxy for better performance and security.

**Commands (Red Hat/CentOS/Fedora):**
```bash
# 1. Install packages
sudo dnf install nginx php-fpm php-cli php-mysqlnd -y

# 2. Start and enable services
sudo systemctl start nginx
sudo systemctl enable nginx
sudo systemctl start php-fpm
sudo systemctl enable php-fpm

# 3. Deploy the Exam System
# Assuming you have the exam files in /home/user/exam_system
sudo cp -r /home/user/exam_system /var/www/html/exam_system

# 4. Set correct permissions
sudo chown -R nginx:nginx /var/www/html/exam_system
sudo chmod -R 755 /var/www/html/exam_system
```

### ⚠️ Gotcha: SELinux Context
Red Hat uses SELinux, which is a mandatory access control system. If you forget to set the correct security context, Nginx will not be able to read the files, and you will get a "403 Forbidden" error.
```bash
sudo chcon -R -t httpd_sys_content_t /var/www/html/exam_system
```

## 3. Internal DNS Sinkhole (Dnsmasq)

This is the key to rendering the internet useless. We will use Dnsmasq to resolve only the exam domain and block all others.

**Commands:**
```bash
# 1. Install Dnsmasq
sudo dnf install dnsmasq -y

# 2. Configure Dnsmasq
# Create a configuration file: /etc/dnsmasq.d/exam.conf
sudo tee /etc/dnsmasq.d/exam.conf > /dev/null <<EOF
# Only resolve the local exam domain
address=/exam.local/192.168.1.1

# Block all other external DNS queries by not forwarding them
# This makes any attempt to access chatgpt.com or google.com fail.
# If you want to be extra strict, you can remove all server= lines.
# server=8.8.8.8 (DO NOT INCLUDE THIS)
EOF

# 3. Start and enable Dnsmasq
sudo systemctl start dnsmasq
sudo systemctl enable dnsmasq
```

### ⚠️ Gotcha: Systemd-resolved
On modern Linux systems, `systemd-resolved` often conflicts with Dnsmasq. You may need to disable it:
```bash
sudo systemctl disable systemd-resolved
sudo systemctl stop systemd-resolved
```

## 4. Firewall Configuration (The "Kill Switch")

We use `firewalld` to implement the airtight network policy.

**Commands:**
```bash
# 1. Install firewalld (if not already)
sudo dnf install firewalld -y
sudo systemctl start firewalld
sudo systemctl enable firewalld

# 2. Allow only necessary traffic to the server (HTTP/HTTPS/DNS)
sudo firewall-cmd --zone=public --add-port=80/tcp --permanent
sudo firewall-cmd --zone=public --add-port=443/tcp --permanent
sudo firewall-cmd --zone=public --add-port=53/udp --permanent # For DNS

# 3. Implement the "Kill Switch" (Crucial Step)
# This rule is tricky and often requires iptables for fine-grained control, 
# but we can achieve the same by setting the default policy to DROP and only allowing specific traffic.

# For a simple setup, ensure your router is NOT forwarding internet traffic to the student network.
# The most effective software-based "Kill Switch" is on the student host (see Phase 2).
# On the Red Hat VM, we ensure it does NOT act as a router for the student network:
sudo sysctl -w net.ipv4.ip_forward=0 # Disable IP forwarding
```

### ⚠️ Gotcha: IP Forwarding
If `net.ipv4.ip_forward` is enabled, the Red Hat VM will route traffic to the internet if it has a second network interface connected to the WAN. **Ensure it is disabled (`=0`)** to prevent students from using the VM as a gateway to the internet.
