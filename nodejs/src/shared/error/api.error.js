/**
 * @version 1.0.0
 */
class ApiError extends Error {
  constructor(message, code, details) {
    super(message);

    this.name = 'ApiError';
    this.code = code;
    this.details = details;
  }

  toObject(stack = false) {
    return ApiError.toObject(this, stack);
  }

  toString() {
    return JSON.stringify(this.toObject());
  }

  // ********* Static methods ********* //

  static toObject(error, stack = false) {
    const baseErrorKeys = ['name', 'message', 'stack'];
    const keys = [...new Set([...baseErrorKeys, ...Reflect.ownKeys(error)])];

    if (!stack) {
      const index = keys.indexOf('stack');
      if (index !== -1) keys.splice(index, 1);
    }

    return keys.reduce((obj, k) => {
      if (typeof error[k] === 'function') return obj;
      obj[k] = error[k];
      return obj;
    }, {});
  }

  static from(error, status, message, additional = {}, stack = false) {
    return new ApiError(message || error.message, status, Object.assign(this.toObject(error, stack), additional));
  }
}

export default ApiError;
