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
<?php
    if( is_user_logged_in() ){
        $user_data = get_userdata( get_current_user_id() );
        $all_meta_for_user = get_user_meta( get_current_user_id() );
    }
?>

    <footer class="footer">
        <div class="container">
            <div class="footer-links">
                <div class="image">
                    <a class="image-1" href="https://fz2020.ru/">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logos/logo_friendzona-03.svg" alt="FRIENDзона">
                    </a>
                    <div class="decoration"></div>
                    <a class="image-2" href="https://pv-real.ru/" target="_blank">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logos/peresvet-w.svg" alt="FRIENDзона">
                    </a>
                </div>
                <div class="links">
                    <div>
                        <a href="https://fz2020.ru/#block-2-ancor">О программе</a>
                        <a href="https://fz2020.ru/#block-3-4-ancor">Условия</a>
                        <a href="https://fz2020.ru/news/">Новости</a>
                        <a href="https://fz2020.ru/#block-8-ancor">Контакты</a>
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
                <div class="copyright">
                    <a href="#">© 2012-2021 Пересвет.Недвижимость</a>
                </div>
                <div class="rules">
                    <a href="<?php echo get_template_directory_uri(); ?>/assets/privacy.pdf" target="_blank">Политика конфиденциальности</a>
                    <a href="<?php echo get_template_directory_uri(); ?>/assets/rules.pdf" target="_blank">Правила</a>
                </div>
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
                            <a class="image-1" href="https://fz2020.ru/">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logos/logo_friendzona-03.svg" alt="FRIENDзона">
                            </a>
                            <div class="decoration"></div>
                            <a class="image-2" href="https://pv-real.ru/" target="_blank">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logos/peresvet-w.svg" alt="FRIENDзона">
                            </a>
                        </div>
                        <div class="buttons">
                            <?php
                                if( is_user_logged_in() ){ ?>
                                    <div class="login d-flex user-info">
                                        <div class="avatar">
                                            <img src="<?php if(isset($all_meta_for_user['user_avatar'])){print wp_get_attachment_image_url($all_meta_for_user['user_avatar'][0]);} else {echo get_template_directory_uri().'/assets/images/avatar-new-grey.svg';} ?>" alt="user-avatar">
                                        </div>
                                        <div class="user"><?php echo $user_data->get('display_name'); ?></div>
                                        <div class="actions">
                                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/chevron-down.svg" alt="chevron-down">
                                        </div>
                                        <div class="drop-down-menu d-none">
                                            <a class="user-link" href="https://fz2020.ru/user/?n=1">Профиль</a>
                                            <a class="user-link" href="https://fz2020.ru/user/?n=2">Друзья</a>
                                            <a class="user-link" href="https://fz2020.ru/user/?n=3">Настройки</a>
                                            <div class="decoration"></div>
                                            <a class="user-logout" href="<?php echo wp_logout_url( home_url() ); ?>">Выйти</a>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <div class="not-login d-flex">
                                        <button class="button-login login-button">Войти</button>
                                        <button class="button-registration registration-button">Зарегистрироваться</button>
                                    </div>
                                <?php }
                            ?>
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
                            <a href="https://fz2020.ru/#block-2-ancor" class="ancor-link">О программе</a>
                            <a href="https://fz2020.ru/#block-3-4-ancor" class="ancor-link">Условия</a>
                            <a href="https://fz2020.ru/news/">Новости</a>
                            <a href="https://fz2020.ru/#block-8-ancor" class="ancor-link">Контакты</a>
                        </div>
                    </div>
                    <div class="modal-menu-copyright">
                        <div class="copyright d-none">
                            <a href="#">© 2012-2021 Пересвет.Недвижимость</a>
                        </div>
                        <div class="rules">
                            <a href="<?php echo get_template_directory_uri(); ?>/assets/privacy.pdf" target="_blank">Политика конфиденциальности</a>
                            <a href="<?php echo get_template_directory_uri(); ?>/assets/rules.pdf" target="_blank">Правила</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-reg d-none">
            <div class="container">
                <div class="reg-form-info">
                    <h2>Регистрация в&nbsp;личном&nbsp;кабинете</h2>
                    <p>В личном кабинете вы можете просматривать кто воспользовался вашей рекомендацией, сколько баллов на вашем счету, задавать вопросы специалистам компании.</p>
                    <div class="image">
                    </div>
                </div>
                <div class="reg-form-inputs d-flex">
                    <form method="post" id="form-reg"></form>
                    <input type="hidden" name="action" value="registration" form="form-reg">
                    <div class="inputs">
                        <input type="text" name="fio" placeholder="ФИО *" form="form-reg" id="form-reg-fio">
                        <input type="tel" name="tel" placeholder="Телефон *" form="form-reg" id="form-reg-tel">
                        <input type="text" name="city" placeholder="Город *" form="form-reg" id="form-reg-city">
                        <input type="text" name="card" placeholder="Карта клиента" form="form-reg" id="form-reg-card">
                    </div>
                    <div class="checkbox">
                        <input type="checkbox" id="rules" name="rules" form="form-reg">
                        <label for="rules">С условиями участия ознакомлен</label>
                    </div>
                    <div class="submit">
                        <input type="button" value="Зарегистрироваться" form="form-reg" id="modal-reg-button">
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
                    <form method="post" id="form-login"></form>
                    <input type="hidden" name="action" value="login" form="form-login">
                    <div class="inputs">
                        <input type="text" name="u-login" placeholder="Телефон" form="form-login" id="form-login-u-login">
                        <input class="pass-lock" type="password" name="u-pass" placeholder="Пароль" form="form-login" id="form-login-u-pass">
                    </div>
                    <div class="text">
                        <a href="#" id="modal-pass-forget">Забыли пароль?</a>
                    </div>
                    <div class="submit">
                        <input type="submit" value="Войти" form="form-login" id="form-login-submit">
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
                    <form action="user.html" method="get" id="form-pass-restore"></form>
                    <div class="inputs">
                        <input type="tel" id="form-pass-restore-tel" name="u-tel" placeholder="Номер телефона*" form="form-pass-restore" required>
                    </div>
                    <div class="text">
                        <a href="#" class="login-button">Я вспомнил пароль</a>
                    </div>
                    <div class="submit">
                        <input type="button" value="Продолжить" form="form-pass-restore" id="form-pass-restore-tel-button">
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
                    <p>Оставьте заявку и мы вам перезвоним,<br>ваш 1 бонусный балл = 1 рублю<br>Минимальная сумма 20 000</p>
                </div>
                <div class="money-form-inputs d-flex">
                    <form method="post" id="form-money"></form>
                    <input type="hidden" name="action" value="get-money" form="form-money">
                    <div class="inputs">
                        <input type="tel" name="u-summ" placeholder="Сумма" form="form-money" id="form-money-u-summ">
                    </div>
                    <div class="checkbox">
                        <input type="checkbox" name="form-money-u-agree" form="form-money" id="form-money-u-agree">
                        <label for="form-money-u-agree">Я подтверждаю снятие баллов</label>
                    </div>
                    <div class="submit">
                        <input type="button" value="Отправить" form="form-money" id="form-money-submit">
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
                    <form method="post" id="form-question"></form>
                    <input type="hidden" name="action" value="send-message" form="form-question">
                    <input type="hidden" name="user-login" value="<?php echo $user_data->user_login; ?>" form="form-question">
                    <input type="hidden" name="user-email" value="<?php if(isset($all_meta_for_user['email'])){ echo $all_meta_for_user['email'][0]; } ?>" form="form-question">
                    <div class="inputs">
                        <textarea name="user-question" id="user-question" placeholder="Ваше сообщение*" form="form-question"></textarea>
                    </div>
                    <div class="submit">
                        <input type="submit" value="Отправить" form="form-question">
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

    <div class="pop-up d-none" id="pop-up">
        <div class="message ok">
            <div class="icon"></div>
            <div class="text">Текст информационного сообщения</div>
            <div class="close ">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icon-cross-black.svg" alt="icon-cross-black">
            </div>
        </div>
    </div>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
