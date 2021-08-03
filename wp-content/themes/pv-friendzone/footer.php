<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package pv-friendZONE
 */

?>

    <footer class="footer">
        <div class="container">
        <div class="footer-links">
            <div class="image">
                <a href="http://bynextpr.ru/">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/footer-logo.svg" alt="footer-logo">
                </a>
            </div>
            <div class="links">
                <div>
                    <a href="http://bynextpr.ru/#block-2">О программе</a>
                    <a href="http://bynextpr.ru/#block-3-4">Условия</a>
                    <a href="http://bynextpr.ru/news/">Новости</a>
                    <a href="http://bynextpr.ru/#block-8">Контакты</a>
                </div>
                <div>
                    <a href="https://vk.com/pvreal" target="_blank">Vkontakte</a>
                    <a href="https://www.facebook.com/pvreal1/" target="_blank">Facebook</a>
                    <a href="https://www.instagram.com/pvreal/" target="_blank">Instagram</a>
                    <a href="https://www.youtube.com/channel/UCNeW3BEXBvySPZjzuEmWvrg" target="_blank">Youtube</a>
                </div>
            </div>
        </div>
    </div>
        <div class="container">
        <div class="footer-copyright">
            <a href="#">© 2012-2021 Пересвет.Недвижимость</a>
            <a href="#">Политика конфиденциальности</a>
        </div>
    </div>
        <div class="container">
        <div class="made-by">
            <a href="https://github.com/boriscom123" target="_blank">#ByNextPr</a>
        </div>
    </div>
    </footer>

    <div class="modals d-none">

        <div class="header-menu d-none">
            <div class="container-modal">
                <div class="container">
                    <div class="modal-menu-buttons">
                        <div class="image">
                            <a href="http://bynextpr.ru/">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/footer-logo.svg" alt="footer-logo">
                            </a>
                        </div>
                        <div class="buttons">
                            <div class="not-login d-flex">
                                <button class="button-login login-button">Войти</button>
                                <button class="button-registration registration-button">Зарегистрироваться</button>
                            </div>
                            <div class="login d-none">
                                <div class="avatar">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/user-avatar.svg" alt="user-avatar">
                                </div>
                                <div class="user">Иван</div>
                                <div class="actions">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/chevron-down.svg" alt="chevron-down">
                                </div>
                            </div>
                            <div class="close" id="close-burger-menu">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icon-cross.svg" alt="icon-cross">
                            </div>
                        </div>
                    </div>
                    <div class="modal-menu-links">
                        <div>
                            <a href="https://vk.com/pvreal" target="_blank">Vkontakte</a>
                            <a href="https://www.facebook.com/pvreal1/" target="_blank">Facebook</a>
                            <a href="https://www.instagram.com/pvreal/" target="_blank">Instagram</a>
                            <a href="https://www.youtube.com/channel/UCNeW3BEXBvySPZjzuEmWvrg" target="_blank">Youtube</a>
                        </div>
                        <div class="active">
                            <a href="http://bynextpr.ru/#block-2" class="ancor-link">О программе</a>
                            <a href="http://bynextpr.ru/#block-3-4" class="ancor-link">Условия</a>
                            <a href="http://bynextpr.ru/news/">Новости</a>
                            <a href="http://bynextpr.ru/#block-8" class="ancor-link">Контакты</a>
                        </div>
                    </div>
                    <div class="modal-menu-copyright">
                        <a href="#">© 2012-2021 Пересвет.Недвижимость</a>
                        <a href="#">Политика конфиденциальности</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-reg d-none">
        <div class="container">
            <div class="reg-form-info">
                <h2>Регистрация в&nbsp;личном&nbsp;кабинете</h2>
                <p>В личном кабинете вы можете просматривать историю переданных показаний и платежей, задавать вопросы специалистам компании</p>
                <div class="image">
                </div>
            </div>
            <div class="reg-form-inputs d-flex">
                <form action="user.html" method="get" id="form-reg"></form>
                <div class="inputs">
                    <input type="text" name="f" placeholder="Фамилия*" form="form-reg" id="form-reg-f">
                    <input type="text" name="i" placeholder="Имя*" form="form-reg" id="form-reg-i">
                    <input type="tel" name="tel" placeholder="Телефон*" form="form-reg" id="form-reg-tel">
                </div>
                <div class="checkbox">
                    <input type="checkbox" id="rules" name="rules" form="form-reg">
                    <label for="rules">С условиями участия ознакомлен</label>
                </div>
                <div class="submit">
                    <input type="submit" value="Зарегистрироваться" form="form-reg" id="modal-reg-button">
                </div>
                <div class="text">
                    <p>Отправляя данные, вы даете согласие на обработку персональных данных и соглашаетесь c политикой конфиденциальности</p>
                </div>
            </div>
            <div class="reg-form-check-tel d-none">
                <h2>Введите пароль</h2>
                <div class="text">
                    <p>Мы отправили пароль в СМС на номер</p>
                    <p>+7 (912) 345-67-89</p>
                </div>
                <div class="input">
                    <input type="text" name="code" placeholder="Пароль из СМС*" form="form-reg"  id="form-reg-code">
                </div>
                <div class="timer">
                    <p>Отправить повторно через <span>59</span> сек.</p>
                </div>
                <div class="submit">
                    <input type="submit" value="Продолжить" form="form-reg" id="modal-reg-button-confirm">
                </div>
            </div>
            <div class="close close-modal">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icon-cross-black.svg" alt="icon-cross-black">
            </div>
        </div>
    </div>

        <div class="form-login d-none">
        <div class="container">
            <div class="login-form-info">
                <h2>Войти в&nbsp;личный&nbsp;кабинет</h2>
                <div class="image">
                    <div class="image-1"></div>
                    <div class="image-2"></div>
                </div>
            </div>
            <div class="login-form-inputs d-flex">
                <form action="user.html" method="get" id="login"></form>
                <div class="inputs">
                    <input type="text" name="u-login" placeholder="Телефон или почта" form="login" required>
                    <input type="password" name="u-pass" placeholder="Пароль" form="login" required>
                </div>
                <div class="text">
                    <a href="#" id="modal-pass-forget">Забыли пароль?</a>
                </div>
                <div class="submit">
                    <input type="submit" value="Войти" form="login">
                </div>

            </div>
            <div class="close close-modal">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icon-cross-black.svg" alt="icon-cross-black">
            </div>
        </div>
    </div>

        <div class="form-pass-restore d-none">
        <div class="container">
            <div class="pass-restore-info">
                <h2>Восстановить пароль</h2>
                <p>Для восстановления пароля введите номер телефона, который вы указали при регистрации</p>
            </div>
            <div class="pass-restore-inputs d-flex">
                <form action="user.html" method="get" id="pass-restore"></form>
                <div class="inputs">
                    <input type="tel" name="u-tel" placeholder="Номер телефона*" form="pass-restore" required>
                </div>
                <div class="text">
                    <a href="#" class="login-button">Я вспомнил пароль</a>
                </div>
                <div class="submit">
                    <input type="submit" value="Продолжить" form="pass-restore">
                </div>

            </div>
            <div class="close close-modal">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icon-cross-black.svg" alt="icon-cross-black">
            </div>
        </div>
    </div>

        <div class="form-money d-none">
        <div class="container">
            <div class="money-form-info">
                <h2>Вывод денежных средств</h2>
                <p>Оставьте заявку и мы вам перезвоним,<br>ваш 1 бонусный балл = 1 рублю</p>
            </div>
            <div class="money-form-inputs d-flex">
                <form action="user.html" method="get" id="form-money"></form>
                <div class="inputs">
                    <input type="tel" name="u-summ" placeholder="Сумма" form="form-money" id="form-money-u-summ">
                </div>
                <div class="checkbox">
                    <input type="checkbox" id="agree" name="agree" form="form-money" id="form-money-u-agree">
                    <label for="agree">Я подтверждаю снятие баллов</label>
                </div>
                <div class="submit">
                    <input type="submit" value="Отправить" form="form-money" id="form-money-submit">
                </div>

            </div>
            <div class="close close-modal">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icon-cross-black.svg" alt="icon-cross-black">
            </div>
        </div>
    </div>

        <div class="form-question d-none">
        <div class="container">
            <div class="form-question-info">
                <h2>Задать вопрос</h2>
                <p>Ответ на вопрос отправим на почту, указанную в личном кабинете</p>
            </div>
            <div class="form-question-inputs d-flex">
                <form action="user.html" method="get" id="question"></form>
                <div class="inputs">
                    <textarea name="u-question" id="u-question" placeholder="Ваше сообщение*" form="question"></textarea>
                </div>
                <div class="submit">
                    <input type="submit" value="Отправить" form="question">
                </div>

            </div>
            <div class="close close-modal">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icon-cross-black.svg" alt="icon-cross-black">
            </div>
        </div>
    </div>

        <div class="confirm d-none">
        <div class="container">
            <div class="confirm-message">
                <div class="checked">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/check.svg" alt="check">
                </div>
                <p>Данные успешно отправлены, мы свяжемся с вами в ближайшее время.</p>
            </div>
            <div class="close close-modal">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icon-cross-black.svg" alt="icon-cross-black">
            </div>
        </div>
    </div>

    </div>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
