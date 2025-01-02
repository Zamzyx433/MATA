
# MATA-SERVER

![Banner](banner.png)

![GitHub stars](https://img.shields.io/github/stars/wanzxploit/MATA-SERVER?style=social)
![Version](https://img.shields.io/badge/version-1.5-brightgreen)
![Python](https://img.shields.io/badge/python-3.7+-blue)
![PHP](https://img.shields.io/badge/php-7.4-blue)
![Platform](https://img.shields.io/badge/platform-linux%20%7C%20termux-lightgrey)

**MATA-SERVER** is the PHP web server version of the MATA project. Unlike the terminal-based PHP version hosted at [MATA Repository](https://github.com/wanzxploit/MATA), this version provides a web interface for simulating and analyzing website visits through various user agents and referrers. This project is designed for educational purposes and web traffic simulation.

---

## Features

- Web-based interface for managing simulated visits.
- Dynamic user agents and referrer injection for realistic results.
- Progress tracking and detailed logs for each visit.
- Responsive design for mobile and desktop browsers.

---

## Requirements

### Web Hosting
- PHP >= 7.4
- cURL extension enabled

### Localhost (Linux/Termux)
- PHP >= 7.4 installed
- Python >= 3.7 for running the request client
- Necessary libraries installed (`requests` for Python)

---

## Installation

### For Web Hosting
1. Download the source files from this repository.
2. Upload the files to your web hosting server.
3. Ensure that the server has PHP and the cURL extension enabled.
4. Access the application via your browser by navigating to the uploaded directory.

### For Localhost (Linux/Termux)
1. Clone the repository:
   ```bash
   git clone https://github.com/wanzxploit/MATA-SERVER.git
   cd MATA-SERVER
   ```

2. Update and install dependencies for Linux:
   ```bash
   sudo apt update && sudo apt upgrade -y
   sudo apt install php php-curl -y
   ```

   For Termux:
   ```bash
   pkg update && pkg upgrade -y
   pkg install php -y
   ```

3. Start the server using PHP's built-in server:
   ```bash
   php -S localhost:8080
   ```

4. Open your browser and navigate to:
   [http://localhost:8080](http://localhost:8080)

---

## Running the Python Client (main.py)

The Python client can send requests to your running MATA-SERVER for automated testing.

### Installation
1. Install Python dependencies:
   ```bash
   pip install requests
   ```

2. Create a `request.txt` file containing the target URL(s). Each URL should be on a new line. Example:
   ```
   https://example.com
   https://another-example.com
   ```

3. Run the Python client with the following command:
   ```bash
   python3 main.py
   ```

### Notes
- The Python client reads the `request.txt` file and sends requests to the PHP server at `localhost:8080`.
- Ensure the PHP server is running before executing the Python client.

---

## Additional Information

### Files
- `main.py`: Python client for sending requests.
- `request.txt`: Text file containing URLs for testing.
- `index.php`: Main PHP script for managing web visits.

### Support
For more details, contact [Wanz Xploit](https://github.com/wanzxploit).

---

**Disclaimer:** This tool is strictly for educational purposes and ethical use. Misuse of this tool is prohibited.
