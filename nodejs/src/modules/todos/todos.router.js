import { Router } from 'express';
import TodosController from './todos.controller.js';
import { validateCreateOne, validateUpdateOne } from './todos.middlewares.js';

const todosRouter = Router();
const todosController = new TodosController();

todosRouter.get('/', todosController.getMany.bind(todosController));
todosRouter.post('/', validateCreateOne, todosController.createOne.bind(todosController));
todosRouter.patch('/:id', validateUpdateOne, todosController.updateOne.bind(todosController));

export default todosRouter;
