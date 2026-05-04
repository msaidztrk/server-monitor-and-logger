import psutil
from app.collectors.base import MetricCollector

class SystemCollector(MetricCollector):
    def collect(self) -> dict:
        return {
            "cpu_usage": psutil.cpu_percent(interval=1),
            "ram_usage": psutil.virtual_memory().percent,
            "disk_usage": psutil.disk_usage('/').percent
        }
