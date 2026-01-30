# Detailed Guide: Windows Host (Student) Lockdown

The student's Windows host is the most vulnerable point. We must lock it down into a Kiosk-like state using a combination of Windows settings and specialized software.

## 1. Static IP and DNS Configuration

This step is crucial for forcing the student machine to use the Red Hat VM's DNS sinkhole.

| Parameter | Value | Action | Why it Matters |
| :--- | :--- | :--- | :--- |
| **IP Address** | `192.168.1.101` (or similar) | Set Manually | Prevents IP conflicts and ensures the Admin knows the student's address. |
| **Subnet Mask** | `255.255.255.0` | Set Manually | Standard local network mask. |
| **Default Gateway** | `192.168.1.1` (Red Hat VM IP) | Set Manually | Even though the VM is not routing to the internet, setting this is a good practice for internal network communication. |
| **Preferred DNS Server** | `192.168.1.1` (Red Hat VM IP) | **CRITICAL** | **Forces all DNS queries to the Red Hat VM's sinkhole.** |
| **Alternate DNS Server** | (Leave Blank) | **CRITICAL** | Prevents the student from falling back to a public DNS (like 8.8.8.8) if the primary fails. |

### ⚠️ Gotcha: WiFi Disabling
If the student laptop has a built-in WiFi adapter, you **MUST** disable it physically or through Windows Device Manager. The student should only be connected via the Ethernet cable to the exam network.

## 2. Windows Group Policy Objects (GPO) Lockdown

Use the **Local Group Policy Editor** (`gpedit.msc`) to disable system functions.

| GPO Path | Setting | Action | Why it Matters |
| :--- | :--- | :--- | :--- |
| User Configuration\Administrative Templates\System\Ctrl+Alt+Del Options | **Remove Task Manager** | Enabled | Prevents students from killing the exam browser or monitoring processes. |
| User Configuration\Administrative Templates\System | **Prevent access to command prompt** | Enabled | Blocks running scripts, changing network settings, or launching unauthorized programs. |
| User Configuration\Administrative Templates\Windows Components\File Explorer | **Hide specified drives in My Computer** | Enabled | Prevents access to USB drives or other local storage. |
| User Configuration\Administrative Templates\System\Removable Storage Access | **All Removable Storage classes: Deny all access** | Enabled | A stronger block on USB drives and external media. |

### ⚠️ Gotcha: GPO Refresh
After making changes in `gpedit.msc`, you must force a policy update. Open Command Prompt (before disabling it!) and run:
```bash
gpupdate /force
```

## 3. Safe Exam Browser (SEB) Configuration

SEB is the most effective software tool for creating a secure testing environment.

| Step | Action | Details | Why it Matters |
| :--- | :--- | :--- | :--- |
| **3.1** | **Download and Install SEB** | Get the latest version from the official website. | It's free and designed for this exact purpose. |
| **3.2** | **Create Configuration File** | Use the SEB Configuration Tool to create a `.seb` file. | This file contains all the lockdown rules. |
| **3.3** | **Configure Start URL** | Set the **Start URL** to the exam server's address: `http://192.168.1.1/exam_system/student/login.php` (or `http://exam.local/student/login.php`). | SEB will only allow navigation within this domain. |
| **3.4** | **Disable Features** | In the **Prohibited Processes** section, add common cheating apps (e.g., `Discord.exe`, `Zoom.exe`, `chrome.exe` if not using SEB's embedded browser). | SEB will refuse to launch if these are running. |
| **3.5** | **Lockdown Shortcuts** | Ensure all options like **Allow switching to other applications** and **Enable Task Manager** are **UNCHECKED**. | This is the software-level block for Alt+Tab and other shortcuts. |
| **3.6** | **Save and Distribute** | Save the configuration as a `.seb` file and place it on the student's desktop. The student will double-click this file to start the exam. | This ensures the lockdown settings are applied every time. |

### ⚠️ Gotcha: SEB Password
Set a **Quit Password** in the SEB configuration. Without this password, the student cannot exit the exam environment, making the lockdown truly effective. **Do not share this password with the students.**
