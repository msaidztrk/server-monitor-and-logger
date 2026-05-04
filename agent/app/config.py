import os
from dataclasses import dataclass
from dotenv import load_dotenv

load_dotenv()

@dataclass(frozen=True)
class Config:
    api_url: str = os.getenv("API_URL")
    server_token: str = os.getenv("SERVER_TOKEN")
    interval: int = int(os.getenv("INTERVAL"))
    log_level: str = os.getenv("LOG_LEVEL")

    def validate(self):
        if not self.server_token:
            raise ValueError("SERVER_TOKEN must be set in environment.")
        if not self.api_url:
            raise ValueError("API_URL must be set in environment.")
