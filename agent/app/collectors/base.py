from abc import ABC, abstractmethod

class MetricCollector(ABC):
    @abstractmethod
    def collect(self) -> dict:
        pass
