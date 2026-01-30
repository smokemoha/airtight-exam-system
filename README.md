# Project: Airtight E-Exam System Hardening

##  Overview: Securing Legacy Educational Technology

This repository contains the source code for a functional, albeit vulnerable, PHP-based e-exam system, along with comprehensive documentation detailing a **Defense-in-Depth** strategy to secure it.

The project's primary goal was to transform a system with a critical, unfixable application-level vulnerability (client-side answer exposure) into an **airtight, cheat-proof environment** using robust System and Network Administration controls. This demonstrates a practical approach to securing legacy systems where code modification is not feasible.

##  The Core Vulnerability (Legacy Code)

The original exam system suffers from a common flaw in older educational platforms:
*   **Client-Side Answer Exposure:** The correct answers for the exam questions are loaded directly into a JavaScript variable on the student's browser (`exam.php`), making them visible via "Inspect Element."

##  The Defense-in-Depth Architecture

Since the application code could not be fixed, a three-layered security architecture was implemented to render the vulnerability irrelevant:

| Layer | Component | Security Mechanism | Goal |
| :--- | :--- | :--- | :--- |
| **1. Application & Gateway** | Red Hat VM | Nginx, PHP-FPM, Dnsmasq | Host the exam and act as the network's single point of control. |
| **2. Network Isolation** | Red Hat VM + Router | **DNS Sinkholing**, Firewall Rules | Block all external internet access (ChatGPT, Google) and rogue network devices. |
| **3. Host Lockdown** | Windows Host (Student) | **Safe Exam Browser (SEB)**, GPO | Prevent local tampering (Alt+Tab, Task Manager) and disable the WiFi adapter. |

##  Key Components

*   **Red Hat VM:** Serves as the web server (`192.168.1.1`) and the **DNS Sinkhole**, ensuring all student DNS queries are trapped locally.
*   **Windows Host (Student):** Locked down into a kiosk state using **GPO** (Group Policy Objects) and **SEB** (Safe Exam Browser).
*   **Network:** A closed-loop, static IP network where the 4G router acts only as a physical switch with DHCP disabled.

##  Getting Started

This repository contains the original PHP source code in the `exam_system/` directory.

To replicate the full **Airtight Environment**, please refer to the detailed documentation in the `docs/` directory, which includes:

1.  **`docs/SETUP_REDHAT.md`**: Step-by-step guide for configuring the Red Hat VM (Nginx, Dnsmasq, Firewall).
2.  **`docs/SETUP_WINDOWS.md`**: Detailed instructions for locking down the Windows Host (GPO, SEB configuration).
3.  **`docs/WORKFLOW.md`**: The complete "Exam Day" operational checklist and verification tests.

##  Documentation

The full security analysis and implementation guides are included in the repository to demonstrate the project's scope and technical depth.
