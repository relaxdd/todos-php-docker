import { z } from 'zod';
import validateRequest from '../../middlewares/validate-request.js';

const updateOneSchema = {
  params: z.object({
    id: z.coerce.number().int().positive(),
  }),
  body: z.object({
    completed: z.boolean(),
  }),
};

export const validateCreateOne = validateRequest({});
export const validateUpdateOne = validateRequest(updateOneSchema);
