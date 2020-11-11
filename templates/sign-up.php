<main>
    <nav class="nav">
      <ul class="nav__list container">
      <?php foreach ($categories as $category): ?>
          <li class="nav__item <?php if($category['id'] == $_GET['category_id']) {echo 'nav__item--current';} ?>">
            <a href="all-lots.php?category_id=<?= $category['id'] ?>"><?= htmlspecialchars($category['name']); ?></a>
          </li>
        <?php endforeach; ?>  
      </ul>
    </nav>
    <form class="form container <?= !empty($errors) ? 'form--invalid' : '' ?>" action="registration.php" method="post" autocomplete="off">
      <h2>Регистрация нового аккаунта</h2>
      <div class="form__item <?= isset($errors['email']) ? 'form__item--invalid' : ''; ?>">
        <label for="email">E-mail <sup>*</sup></label>
        <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?= htmlspecialchars($email); ?>">
        <span class="form__error"><?= $errors['email'] ?? ''; ?></span>
      </div>
      <div class="form__item <?= isset($errors['password']) ? 'form__item--invalid' : ''; ?>">
        <label for="password">Пароль <sup>*</sup></label>
        <input id="password" type="password" name="password" placeholder="Введите пароль" value="<?= htmlspecialchars($password); ?>">
        <span class="form__error">Введите пароль</span>
      </div>
      <div class="form__item <?= isset($errors['name']) ? 'form__item--invalid' : ''; ?>">
        <label for="name">Имя <sup>*</sup></label>
        <input id="name" type="text" name="name" placeholder="Введите имя" value="<?= htmlspecialchars($first_name); ?>">
        <span class="form__error">Введите имя</span>
      </div>
      <div class="form__item <?= isset($errors['message']) ? 'form__item--invalid' : ''; ?>">
        <label for="message">Контактные данные <sup>*</sup></label>
        <textarea id="message" name="message" placeholder="Напишите как с вами связаться"><?= htmlspecialchars($message) ?></textarea>
        <span class="form__error">Напишите как с вами связаться</span>
      </div>
      <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
      <button type="submit" class="button">Зарегистрироваться</button>
      <a class="text-link" href="user-login.php">Уже есть аккаунт</a>
    </form>
  </main>