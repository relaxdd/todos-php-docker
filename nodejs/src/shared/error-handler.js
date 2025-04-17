import ApiError from './error/api.error.js';

function errorHandler(err, req, res, next) {
  console.log(err);
  
  if (!err) {
    return res.status(500).json({
      error: 'Internal Server Error',
      message: 'Unexpected server behavior',
    });
  }

  const status = err instanceof ApiError ? err.code : 500;
  const isDevelopment = process.env?.NODE_ENV === 'development';

  if (status < 500)
    return res.status(status).json(err.toObject(isDevelopment));
  else {
    if (isDevelopment) {
      return res.status(500).json({
        error: 'Internal Server Error',
        message: err?.message,
        stack: err?.stack,
      });
    }

    return res.status(500).json({
      error: 'Internal Server Error',
      message: 'Some kind of error has occurred on the server',
    });
  }
}

export default errorHandler;
