import { Router } from 'express';
import todosRouter from './modules/todos/todos.router.js';
import postsRouter from './modules/posts/posts.router.js';

const router = Router();

router.get('/', (req, res) => {
  return res.json({ message: 'Hello world from API!' });
});

router.use('/todos', todosRouter);
router.use('/posts', postsRouter);

router.all('/{*any}', (req, res) => {
  return res.status(404).json({ message: 'Неверный адрес api запроса' });
});

export default router;
