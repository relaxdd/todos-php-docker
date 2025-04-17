import express from 'express';
import bodyParser from 'body-parser';
import cookieParser from 'cookie-parser';
import router from './router.js';
import errorHandler from './shared/error-handler.js';

const PORT = parseInt(process.env?.PORT || 3000);

function main() {
  const app = express();
  app.set('trust proxy', true);

  app.use(cookieParser());
  app.use(bodyParser.json());
  app.use(bodyParser.urlencoded({ extended: true }));

  app.use(router);
  app.use(errorHandler);

  app.listen(PORT, () => {
    console.log('[Express] The server is running on port 3000');
  });
}

try {
  main();
} catch (e) {
  console.log(`[NodeJS] ${e?.message}`);
  process.exit(1);
}
