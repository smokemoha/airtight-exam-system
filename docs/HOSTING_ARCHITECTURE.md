# Hosting Architecture and URL Structure

The hosting of your exam system is designed to be entirely **local** and **isolated**, with the Red Hat VM serving as the central hub.

## 1. The Hosting Architecture: How it Works

The entire system operates on a closed-loop network, meaning no external internet connection is required for the exam itself.

| Component | Role | IP Address |
| :--- | :--- | :--- |
| **Red Hat VM** | **Exam Server & DNS Sinkhole** | `192.168.1.1` |
| **Windows Host (Student)** | **Client Workstation** | `192.168.1.101` |
| **Windows Host (Admin)** | **Monitoring & Control** | `192.168.1.10` |
| **4G Router** | **Local Network Switch** | (DHCP Disabled) |

When the student's browser (inside SEB) attempts to access the exam, the following sequence occurs:

1.  **DNS Query:** The student's machine is configured to use the Red Hat VM (`192.168.1.1`) as its DNS server.
2.  **Local Resolution:** The student's browser requests the IP address for the exam domain (e.g., `exam.local`).
3.  **Dnsmasq Response:** The Dnsmasq service on the Red Hat VM intercepts this request and replies with its own IP address: `192.168.1.1`.
4.  **HTTP Request:** The student's browser sends an HTTP request to `192.168.1.1`.
5.  **Nginx/PHP-FPM Processing:** The Nginx web server on the Red Hat VM receives the request, passes it to PHP-FPM to execute the exam code, and returns the resulting HTML page (the login screen).

## 2. The Student Access URL

Because you have configured the Red Hat VM to act as a local DNS server and set up Dnsmasq, the student can access the exam using a friendly domain name, even though it's local.

| URL Component | Value | Purpose |
| :--- | :--- | :--- |
| **Protocol** | `http://` | Standard web protocol. |
| **Domain** | `exam.local` | The friendly name resolved by Dnsmasq to `192.168.1.1`. |
| **Path** | `/exam_system/student/login.php` | The specific file path to the student login page within your deployed code. |

**The final URL the student will use is:** `http://exam.local/exam_system/student/login.php`

This URL is the one you must configure as the **Start URL** in the Safe Exam Browser (`.seb`) configuration file.

## 3. The "Why" of the URL

*   **Why not use the IP address (`192.168.1.1`)?** You *could* use the IP, but using a domain name (`exam.local`) is more professional and allows for easier configuration changes later. More importantly, it verifies that your **DNS Sinkhole** is working correctly. If the student can access the exam via `exam.local`, it proves they are using the Red Hat VM's DNS.
*   **Why is the internet useless?** Any attempt by the student to type `google.com` will be intercepted by the Red Hat VM's Dnsmasq, which will fail to resolve the address (or resolve it to a non-existent local IP), effectively blocking access to the external internet. The firewall rules on the Red Hat VM and the router (if supported) provide a second layer of protection by dropping any non-local traffic.
