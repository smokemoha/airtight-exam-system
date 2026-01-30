# Detailed Guide: Network and Router Configuration for "Airtight" Isolation

This phase focuses on the physical and logical network setup, specifically addressing the challenge of rogue 4G pocket routers.

## 1. Physical Setup and Isolation

The physical connection is the foundation of your security.

| Component | Action | Why it Matters |
| :--- | :--- | :--- |
| **4G Pocket Router** | **Disable WiFi** (if possible) or change the WiFi password to a complex, unshared one. | Forces all traffic to use the Ethernet ports, making physical control easier. |
| **Ethernet Cable** | Use a single, dedicated cable to connect the **Red Hat VM** to one of the router's LAN ports. | Establishes the VM as the central point of the exam network. |
| **Student Host** | Connect the student's Windows Host to a separate LAN port on the router. | Creates the isolated exam network segment. |
| **Unused Ports** | Physically block or disable any unused LAN ports on the router. | Prevents a student from plugging in a rogue device. |

### ⚠️ Gotcha: Router DHCP
Your 4G router's DHCP server might interfere with your static IP plan. **Disable the DHCP server** on the 4G router entirely. Since all IPs are set statically, you don't need it, and disabling it prevents the router from assigning a different IP to the Red Hat VM or student hosts.

## 2. Router-Level Firewall (If Supported)

If your 4G router has a firewall or access control list (ACL) feature, use it to implement the ultimate "Kill Switch."

| Rule Type | Source IP | Destination IP | Protocol/Port | Action | Why it Matters |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **WAN Block** | Student IP Range (`192.168.1.100-199`) | **ANY (WAN)** | **ANY** | **DROP/REJECT** | **The ultimate block.** Prevents any student traffic from leaving the local network, even if they bypass the Red Hat VM's DNS. |
| **Exam Allow** | Student IP Range | Red Hat VM IP (`192.168.1.1`) | TCP 80, 443 | ALLOW | Allows access to the exam server. |

### ⚠️ Gotcha: Consumer Router Limitations
Most consumer-grade 4G pocket routers have very limited firewall capabilities. If your router cannot implement these rules, you must rely entirely on the **Red Hat VM's IP Forwarding Block (Step 4 in Phase 1)** and the **Student Host's DNS Lockdown (Step 1 in Phase 2)**. The combination of these two software controls is a strong substitute for a hardware firewall.

## 3. Countering Rogue Routers and WiFi

This is the most challenging part, as it involves physical security and monitoring.

| Strategy | Action | Role | Why it Matters |
| :--- | :--- | :--- | :--- |
| **Physical Security** | Conduct a thorough physical check of the exam area before and during the exam. | Admin | The simplest and most effective defense against rogue hardware. |
| **Network Scanning** | From the Admin Host, run `nmap -sn 192.168.1.0/24` periodically. | Admin | Detects any unauthorized devices (like a student's hidden 4G router) that have connected to the exam network. |
| **Host WiFi Disable** | Use GPO (as detailed in Phase 2) to disable the student's built-in WiFi adapter. | System Admin | Prevents the student from connecting to a rogue router or mobile hotspot. |

### ⚠️ Gotcha: Mobile Hotspots
A student can use their phone as a mobile hotspot. If the student's laptop is not physically connected to the exam network (i.e., they are using their own WiFi), the GPO/SEB controls will be less effective. **The physical check and GPO-enforced WiFi disable are your primary defenses here.**
