import logging
import sys
from app.config import Config
from app.agent import ServerAgent

logging.basicConfig(
    level=logging.INFO,
    format='%(asctime)s - %(name)s - %(levelname)s - %(message)s'
)

if __name__ == "__main__":
    try:
        config = Config()
        config.validate()
        
        agent = ServerAgent(config)
        agent.run()
        
    except KeyboardInterrupt:
        logging.info("Agent stopped by user.")
        sys.exit(0)
    except Exception as e:
        logging.critical(f"Agent failed to start: {e}")
        sys.exit(1)
