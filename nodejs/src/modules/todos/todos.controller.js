class TodosController {
  constructor() {
    this.todos = [
      { id: 1, title: 'delectus aut autem', completed: true },
      { id: 2, title: 'quis ut nam facilis et officia qui', completed: true },
      { id: 3, title: 'fugiat veniam minus', completed: true },
      { id: 4, title: 'et porro tempora', completed: false },
      { id: 5, title: 'laboriosam mollitia et enim quasi adipisci quia provident illum', completed: true },
      { id: 6, title: 'qui ullam ratione quibusdam voluptatem quia omnis', completed: false },
      { id: 7, title: 'illo expedita consequatur quia in', completed: false },
      { id: 8, title: 'quo adipisci enim quam ut ab', completed: true },
      { id: 9, title: 'molestiae perspiciatis ipsa', completed: true },
      { id: 10, title: 'illo est ratione doloremque quia maiores aut', completed: false },
      { id: 11, title: 'vero rerum temporibus dolor', completed: true },
      { id: 12, title: 'ipsa repellendus fugit nisi', completed: true },
      { id: 13, title: 'et doloremque nulla', completed: true },
      { id: 14, title: 'repellendus sunt dolores architecto voluptatum', completed: true },
      { id: 15, title: 'ab voluptatum amet voluptas', completed: true },
    ];
  }

  getMany(req, res) {
    return res.json(this.todos);
  }

  createOne(req, res) {
    return res.status(201).end();
  }

  updateOne(req, res) {
    const id = req.params.id;
    const completed = req.body.completed;

    /*
     * Update specific todo item
     */

    const index = this.todos.findIndex((it) => it.id === id);
    if (index === -1) return res.status(400).end();
    this.todos[index].completed = completed;

    /*
     * Return success response about update
     */

    return res.json({ id, message: 'Todo successfully updated' });
  }
}

export default TodosController;
