import ApiError from '../shared/error/api.error.js';

function parseZodError(error, source) {
  return error.errors.map((issue) => {
    const issues = issue.path.join('.');

    return {
      issue: issues || source,
      message: `${issues || source} is ${issue.message}`,
    };
  });
}

function validateRequest(sources) {
  return function (req, res, next) {
    for (const source of Object.keys(sources)) {
      if (!sources.hasOwnProperty(source)) continue;
      const result = sources[source].strict().safeParse(req[source]);

      if (!result.success) {
        return next(
          new ApiError('Bad Request', 400, {
            source,
            errors: parseZodError(result.error, source),
          })
        );
      }

      req[source] = result.data;
    }

    return next();
  };
}

export default validateRequest;
