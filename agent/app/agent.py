import time
import logging
from app.config import Config
from app.client.api_client import ApiClient
from app.collectors.system_collector import SystemCollector

class ServerAgent:
    def __init__(self, config: Config):
        self.config = config
        self.client = ApiClient(config)
        self.collectors = [
            SystemCollector()
        ]
        self.logger = logging.getLogger(__name__)

    def run(self):
        self.logger.info(f"Agent started. Polling interval: {self.config.interval}s")
        
        while True:
            try:
                all_metrics = {}
                for collector in self.collectors:
                    all_metrics.update(collector.collect())
                
                success = self.client.post_metrics(all_metrics)
                
                if success:
                    self.logger.debug(f"Metrics sent: {all_metrics}")
                else:
                    self.logger.warning("Metrics delivery failed.")
                    
            except Exception as e:
                self.logger.error(f"Unexpected error in agent loop: {e}")
            
            time.sleep(self.config.interval)
