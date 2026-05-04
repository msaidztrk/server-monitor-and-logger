import requests
import logging
from app.config import Config

class ApiClient:
    def __init__(self, config: Config):
        self.config = config
        self.base_url = config.api_url.rstrip('/')
        self.headers = {
            "Authorization": f"Bearer {config.server_token}",
            "Accept": "application/json",
            "Content-Type": "application/json"
        }
        self.logger = logging.getLogger(__name__)

    def post_metrics(self, data: dict) -> bool:
        try:
            response = requests.post(
                f"{self.base_url}/api/metrics",
                json=data,
                headers=self.headers,
                timeout=10
            )
            response.raise_for_status()
            return True
        except requests.exceptions.RequestException as e:
            self.logger.error(f"Failed to send metrics: {e}")
            return False

    def post_log(self, level: str, message: str) -> bool:
        try:
            response = requests.post(
                f"{self.base_url}/api/logs",
                json={"level": level, "message": message},
                headers=self.headers,
                timeout=10
            )
            response.raise_for_status()
            return True
        except requests.exceptions.RequestException as e:
            self.logger.error(f"Failed to send log: {e}")
            return False
