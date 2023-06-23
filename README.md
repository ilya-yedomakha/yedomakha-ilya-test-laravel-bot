<h1 align="center">Test Laravel Bot</h1>
<h1>Опис:</h1>
    <p>Телеграм бот створений для замовлення їжі в різних містах у різних компаній<p>
<h1>Послідовність дій для відправлення замовлення:</h1>
<ul>
  <li>Надати ботові контакт</li>
  <li>Обрати місто</li>
  <li>Обрати доступні компанії з цього міста</li>
  <li>Обрати категорію страв, що пропонує компанія</li>
  <li>Додати в кошик страву</li>
  <li>Зробити замовлення</li>
</ul>
<p>Вся взаємодія відбувається через API <a href="https://docs.dots.live/">https://docs.dots.live/</a>.<p>
Для взаємодії з телеграм-ботом для отримання оновлень було запущено локальний сервер, а щоб оновлення приходили автоматично, було використано технологію WebHooks.</p>
<p>Для того щоб використовувати вебхуки, скористаємось сервісом ngrok, який надасть тимчасовий домен, для того щоб Telegram API зміг повісити вебхук на наш сервер</p>
<h1>Функції:</h1>
<ul>
  <li>Корзину можна очищати</li>
  <li>Якщо користувач намагається перейти до іншого міста або компанії з заповненим кошиком, бот пропонує або очистити його, або залишити поточний стан кошика з містом, компанією і стравами</li>
  <li>Якщо компанія надає розклад, то на кнопці з цією компанією буде виведено розклад на сьогоднішній день</li>
</ul>
Проект розроблено за допомогою фреймворка Laravel.
