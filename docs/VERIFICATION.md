# The Final State: Verification Checklist

The final phase is to verify that all components are working together to create the "perfect" airtight environment. This checklist defines the expected state of the system and the tests you must perform.

## 1. Expected Final State

When the system is fully configured, the following conditions must be met:

| Component | Expected State |
| :--- | :--- |
| **Red Hat VM** | Running Nginx, PHP-FPM, and Dnsmasq. IP is static (`192.168.1.1`). IP forwarding is disabled. |
| **Student Windows Host** | IP is static (`192.168.1.101`). DNS is set to `192.168.1.1`. WiFi is disabled. GPO prevents access to Task Manager, Command Prompt, and USB drives. |
| **Network** | The 4G router's DHCP is disabled. All devices are connected via Ethernet. |
| **Exam Access** | The student can successfully open the exam via the **Safe Exam Browser (SEB)** and navigate only to the exam pages. |
| **Internet Access** | The student cannot access any external website (e.g., Google, ChatGPT, YouTube) from the SEB or any other application. |

## 2. Verification Checklist (Test Before Exam)

You must perform these tests from the **Student Windows Host** to confirm the security measures are effective.

| Test Action | Expected Result | Pass/Fail |
| :--- | :--- | :--- |
| **A. Connectivity Test** | | |
| Open SEB by double-clicking the `.seb` file. | SEB launches, locks the screen, and displays the exam login page. | |
| Try to exit SEB without the Quit Password. | SEB refuses to close. | |
| **B. Internet Block Test** | | |
| In SEB, try to navigate to `https://www.google.com`. | The page fails to load or shows a DNS error. | |
| Open Command Prompt (if GPO failed) and run `ping 8.8.8.8`. | The ping should fail (Destination Host Unreachable) or time out. | |
| Open Command Prompt and run `nslookup www.chatgpt.com`. | The query should fail or return the Red Hat VM's IP (`192.168.1.1`) due to the DNS sinkhole. | |
| **C. System Lockdown Test** | | |
| Press `Ctrl+Alt+Del` and try to open Task Manager. | Task Manager is blocked or the option is grayed out. | |
| Press `Alt+Tab` or `Win+D` to switch applications. | The screen remains locked by SEB. | |
| Insert a USB drive. | Windows does not recognize the drive or access is denied by GPO. | |
| **D. Rogue Router Test** | | |
| Disconnect the Ethernet cable and try to connect to a mobile hotspot. | The connection should fail because the WiFi adapter is disabled by GPO. | |

## 3. The "Perfect" Final Phase

The final, perfect state is when the student is completely confined to the exam environment:

1.  **Physical Isolation:** The student is connected via a single Ethernet cable to a network that has no internet access.
2.  **Network Isolation:** All traffic is forced to go through the Red Hat VM's DNS, which only resolves the exam server. All other traffic is blocked.
3.  **Host Isolation:** The Windows Host is locked down by GPO and SEB, preventing any access to system tools, external applications, or keyboard shortcuts.
4.  **Admin Control:** The Admin Host can monitor the network and the exam system dashboard without any restrictions.

If all tests in the verification checklist pass, your environment is airtight and ready for the exam.
