(function () {
  /**
   * @param {boolean} disabled
   * @returns {void}
   */
  function toggleTodos(disabled) {
    document.querySelectorAll('.todo-item').forEach((item) => {
      const checkbox = item.querySelector('input[type="checkbox"]');

      if (!disabled) checkbox.removeAttribute('disabled');
      else checkbox.setAttribute('disabled', '');
    });
  }

  /**
   * @param {EventTarget} target
   * @param {boolean} value
   * @returns {void}
   */
  function abortChange(target, value) {
    target.checked = !value;
  }

  /**
   * @param {Response} resp
   * @returns {object|null}
   */
  async function requestError(resp) {
    try {
      return JSON.parse(await resp.text());
    } catch (e) {
      console.error(e);
      return null;
    }
  }

  /**
   * @param {Event} e
   * @returns {Promise<void>}
   */
  async function changeHandler(e) {
    const target = e.target;
    const id = +target.dataset?.id;
    const completed = target.checked;

    toggleTodos(true);

    try {
      const resp = await fetch(`http://localhost/api/v1/todos/${id}`, {
        method: 'PATCH',
        body: JSON.stringify({
          completed,
        }),
        headers: {
          'Content-Type': 'application/json; charset=utf-8',
        },
      });

      if (!resp.ok) {
        const data = await requestError(resp);
        console.error(`${data?.message}: ${data?.details?.errors?.[0]?.message}`);
        abortChange(target, completed);
      }
    } catch (e) {
      console.error(e);
      alert(e?.message);
    } finally {
      toggleTodos(false);
    }
  }

  document.querySelectorAll('.todo-item').forEach((item) => {
    item.querySelector('input[type="checkbox"]')?.addEventListener('change', changeHandler);
  });
})();