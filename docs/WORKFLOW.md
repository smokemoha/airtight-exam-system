# The "Exam Day" Operational Workflow

This guide provides the complete sequence of actions you, as the System/Network Admin, must perform to ensure a successful and secure exam.

## Phase 1: Pre-Exam Setup (The Day Before)

| Step | Action | Details | Verification |
| :--- | :--- | :--- | :--- |
| **1.1** | **Finalize Red Hat VM** | Ensure all services (Nginx, PHP-FPM, Dnsmasq, firewalld) are running and set to start on boot. Verify IP forwarding is disabled (`net.ipv4.ip_forward=0`). | Ping the VM from the Admin Host (`ping 192.168.1.1`). |
| **1.2** | **Lock Down Student Hosts** | Apply the GPO changes (`gpupdate /force`), disable the WiFi adapter, and set the static IP/DNS to the Red Hat VM's IP (`192.168.1.1`). | Run the **Verification Checklist** (from the previous guide) on a test student machine. |
| **1.3** | **Prepare SEB** | Ensure the `.seb` configuration file is on the student desktop, pointing to `http://exam.local/exam_system/student/login.php`. | Double-click the `.seb` file and confirm the login page loads. |
| **1.4** | **Prepare Admin Host** | Ensure your Admin Host has a static IP (`192.168.1.10`) and can access both the Red Hat VM (for management) and the exam system's admin dashboard (`http://exam.local/exam_system/admin/dashboard.php`). | Access the admin dashboard and confirm you can see the student list. |

## Phase 2: Exam Start (The Critical 15 Minutes)

| Step | Action | Details | Why it Matters |
| :--- | :--- | :--- | :--- |
| **2.1** | **Power Up Network** | Turn on the 4G router and the Red Hat VM. | Establishes the isolated network. |
| **2.2** | **Connect Students** | Have students connect their laptops to the designated Ethernet ports. | Ensures they are on the secure, isolated network. |
| **2.3** | **Physical Check** | Visually inspect each student's station for unauthorized devices (phones, rogue routers, USB drives). | The first and most reliable line of defense. |
| **2.4** | **Launch Exam** | Instruct students to double-click the `.seb` file on their desktop. | This locks down their machine and forces them to the exam login page. |
| **2.5** | **Final Check** | From the Admin Host, run `nmap -sn 192.168.1.0/24` to confirm only expected devices are on the network. | Catches any last-minute rogue devices. |

## Phase 3: During the Exam (Monitoring)

| Step | Action | Details | Role |
| :--- | :--- | :--- | :--- |
| **3.1** | **Monitor Dashboard** | Keep the exam system's admin dashboard open on your Admin Host. Look for any students who are blocked or whose session "heartbeat" (if implemented) is missing. | System Admin |
| **3.2** | **Monitor Network** | Periodically check the Red Hat VM's firewall logs for dropped packets. A high number of dropped packets from a student's IP trying to reach external IPs (like 8.8.8.8) indicates a cheating attempt. | Network Admin |
| **3.3** | **Physical Presence** | Walk around the room. Physical presence is a strong deterrent. | System/Network Admin |

## Phase 4: Exam End

| Step | Action | Details | Why it Matters |
| :--- | :--- | :--- | :--- |
| **4.1** | **Collect Submissions** | Instruct students to click "Submit Exam" and wait for the confirmation screen. | Ensures all data is sent to the server. |
| **4.2** | **Exit SEB** | Enter the SEB Quit Password on each machine to unlock the student host. | Releases the student's machine from lockdown. |
| **4.3** | **Shut Down** | Turn off the Red Hat VM and the 4G router. | Secures the exam data and returns the network to a normal state. |
