import subprocess
import time
import os
from rich.console import Console
from rich.panel import Panel
from threading import Thread

console = Console()

class SimplePHPServer:
    def __init__(self, host="127.0.0.1", port=8080):
        self.host = host
        self.port = port
        self.process = None

    def start_server(self):
        directory = os.getcwd()
        try:
            self.process = subprocess.Popen(
                ["php", "-S", f"{self.host}:{self.port}", "-t", directory],
                stdout=subprocess.PIPE,
                stderr=subprocess.PIPE,
                bufsize=1,
                universal_newlines=True
            )
            time.sleep(1)
            return self.process
        except FileNotFoundError:
            console.print(Panel("PHP is not installed or not in PATH", style="bold red"))
            return None

    def stop_server(self):
        if self.process:
            self.process.terminate()
            console.print(Panel(f"Server stopped on {self.host}:{self.port}", style="bold yellow", border_style="red"))

def run_bot(port):
    server = SimplePHPServer(port=port)
    server.start_server()
    console.print(Panel(f"Bot running on [bold blue]http://{server.host}:{port}[/]", style="bold green"))
    try:
        while server.process and server.process.poll() is None:
            time.sleep(1)
    except KeyboardInterrupt:
        server.stop_server()

def main():
    console.clear()
    bots = []
    num_bots = 100  # Tentukan jumlah bot

    console.print(Panel(f"Starting {num_bots} bots...", style="bold green"))
    for i in range(num_bots):
        port = 8080 + i
        thread = Thread(target=run_bot, args=(port,))
        bots.append(thread)
        thread.start()
        time.sleep(0.1)  # Hindari konflik port

    for bot in bots:
        bot.join()

if __name__ == "__main__":
    main()
    
