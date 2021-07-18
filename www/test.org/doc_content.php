<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
      'use strict';
      window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
          form.addEventListener('submit', function(event) {
            if (form.checkValidity() === false) {
              event.preventDefault();
              event.stopPropagation();
            }
            form.classList.add('was-validated');
          }, false);
        });
      }, false);
    })();
  </script>
    <h4>Глоссарий</h4>
    <div class="row">
        <div class="col-5 col-sm-3">
            <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                <a class="nav-link active" id="vert-tabs-messages-tab" data-toggle="pill" href="#link8" role="tab" aria-controls="vert-tabs-messages" aria-selected="false">Баг-репорт и обратная связь</a>
                <a class="nav-link" id="vert-tabs-home-tab" data-toggle="pill" href="#link1" role="tab" aria-controls="vert-tabs-home" aria-selected="true">Описание системы "Журнал ЭТИ№1"</a>
                <a class="nav-link" id="vert-tabs-profile-tab" data-toggle="pill" href="#link2" role="tab" aria-controls="vert-tabs-profile" aria-selected="false">Описание системы "Учет дисков"</a>
                <a class="nav-link" id="vert-tabs-messages-tab" data-toggle="pill" href="#link3" role="tab" aria-controls="vert-tabs-messages" aria-selected="false">Бизнес процесс учета дисков</a>
                <a class="nav-link" id="vert-tabs-messages-tab" data-toggle="pill" href="#link4" role="tab" aria-controls="vert-tabs-messages" aria-selected="false">Добавление нового шаблона диска</a>
                <a class="nav-link" id="vert-tabs-messages-tab" data-toggle="pill" href="#link5" role="tab" aria-controls="vert-tabs-messages" aria-selected="false">Инструкция "Уничтожение диска ОБ"</a>
                <a class="nav-link" id="vert-tabs-messages-tab" data-toggle="pill" href="#link6" role="tab" aria-controls="vert-tabs-messages" aria-selected="false">Лог функционала</a>
            </div>
        </div>
        <div class="col-7 col-sm-9">
            <div class="tab-content" id="vert-tabs-tabContent">

                <div class="tab-pane text-left fade show active" id="link8" role="tabpanel" aria-labelledby="vert-tabs-messages-tab">
                    <h4>Форма обратной связи</h1>
                    <blockquote class="quote-secondary">
                    <small>
                    <p>Данный раздел служит для описания всевозможных багов, ошибок, пожеланий к функционалу и т.д. По факту решения какой-либо проблемы будет отписано в этом же чате.</p>
                    </small>
                    </blockquote>
                    <?php 
                     #Инициализируем переменные для создания комментария
                    $id_comment = '66';
                    $type_comment = 66;
                    $page_comment = "doc.php?&page=5";
                    $page_back_comment = "doc.php?&page=5";
                    include("accounting/comment_disk_form.php");               
                   echo'<hr>';
                    echo show_comments($link,'66', 66);
                     ?>
                </div>

                <div class="tab-pane fade" id="link1" role="tabpanel" aria-labelledby="vert-tabs-home-tab">
                    <h4>
                    Описание системы "Журнал ЭТИ№1" 
                    </h4> 
                        <h5>Назначение Журнала ЭТИ№1:</h5>
                        <ul>
                            <li>
                                Журналирование и централизованное хранение инцидентов рабочей смены Дужерных ЭТИ1
                            </li>
                            <li>
                                Централизованный новостной ресурс
                            </li>            
                            <li>
                                Центр уведолмлений о новых инцидентах / новостях / работах
                            </li>
                        </ul>
                        <h5>Оглавление:</h5>
                        <ol>
                            <li> <a href="#topic10">Общая информация о системе, права доступа</a></li>
                            <li> <a href="#topic11">Начало работы / Окончание работы</a></li>
                            <li> <a href="#topic12">Раздел смены</a></li>
                            <li> <a href="#topic13">Раздел инциденты</a></li>
                            <li> <a href="#topic14">Раздел новости</a></li>
                            <li> <a href="#topic15">Раздел задания</a></li>
                            <li> <a href="#topic16">Раздел загрузки</a></li>
                            <li> <a href="#topic17">Уведомления</a></li>
                            <li> <a href="#topic18">Профиль пользователя</a></li>
                        </ol>
                        <a name="topic10"></a> </br>
                        <h4>       
                        Общая информация о системе, права доступа. 
                        </h4> 
                        <h6>Права доступа</h6>
                        Авторизация в системе интегрирована c LDAP, что означает необходимость иметь УЗ в домене DPC для работы с системой.
                            В системе существует 3 уровня разрешений прав доступа:
                            <ul>
                                <li>
                                    Обычный пользователь: Разрешено создавать новости, задания, загружать файлы, просмотр информации в системе учета дисков.
                                </li>
                                <li>
                                    Дежурный ЭТИ№1: полные права доступа. Разрешено создавать инциденты смены, новости, задания, загружать файлы, редактирование информации в системе учета дисков.
                                </li>
                                <li>
                                   Администратор ИБ: ограниченные права доступа. Доступ разрешен только в дашборд "Администратора ИБ".
                                </li>
                            </ul>
                           Если в процессе работы с системой видите сообщение ниже (см. скриншот ниже) - это означает что прав доступа не достаточно, необходимо обратиться к администратору системы. 
                           <img src="/dist/img/doc1/34.png" class="img-fluid mb-2" alt="red sample"> 
                           <br>

                           <a name="topic11"></a> </br>
                           <h5>Начало работы / Окончание работы</h5>
                           <h6>Начало работы </h6>
                           Пользователь авторизуется в системе учета дисков под обычной УЗ DPC\n7701-**-***.
                           <br>
                           <img src="/dist/img/doc1/1.png" class="img-fluid mb-2" alt="red sample"> 
                           <br>
                           Если авторизация не удачна - обратиться к Администратору системы.
                           <h6>Окончание работы </h6>
                           <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">?</button>
                            <h5><i class="icon fas fa-info"></i> Важно!</h5>
                            Дежурный ЭТИ№1 перед окончанием работы сиcтемой и сдачей смены:
                            <ul>
                                <li>
                                    Прикрепляет отчет за рабочую смену
                                </li>
                                <li>
                                    Закрывает смену
                                </li>
                            </ul>
                          </div>
                          <ul>
                               <li>
                                    Прикрепление отчета
                                    <img src="/dist/img/doc1/35.png" class="img-fluid mb-2" alt="red sample"> 
                                    <img src="/dist/img/doc1/36.png" class="img-fluid mb-2" alt="red sample"> 
                                    Готово
                                    <img src="/dist/img/doc1/37.png" class="img-fluid mb-2" alt="red sample">
                                </li>    
                                <li>
                                    Закрытие смены
                                    <img src="/dist/img/doc1/38.png" class="img-fluid mb-2" alt="red sample">
                                </li>
                          </ul>  

                          <a name="topic13"></a> </br>
                           <h5>Раздел смены</h5>
                           Раздел смен - централизованно хранит все рабочие смены Дежурных ЭТИ№1, состояние всех инцидентов на момемнт закрытие смены, приложенные отчеты за смену.
                           <img src="/dist/img/doc1/39.png" class="img-fluid mb-2" alt="red sample">
                           <br>

                           <a name="topic13"></a> </br>
                           <h5>Раздел инциденты</h5>
                           Раздел инциденты - оторбражает все инциденты Дежурных ЭТИ№1, актуальные на текущий момент времени.<br>
                           <img src="/dist/img/doc1/39.png" class="img-fluid mb-2" alt="red sample">
                           <blockquote class="quote-secondary">
                            <small>
                            <p>
                            Список инцидентов можно фильтровать по любому полю.<br>
                            Список инцидентов можно отправить на печать.<br>
                            Также можно выполнить поиск по всем инцидентам когда-либо созданным, воспольщовавшись формой поиска вернего меню. (см. скриншот ниже)
                            </p>
                            </small>
                             </blockquote>
                             <h6>
                                 Создание нового инцидента
                             </h6>
                             <ul>
                                 <li>
                                     Инциденты -> Создать
                                     <img src="/dist/img/doc1/38.png" class="img-fluid mb-2" alt="red sample">
                                 </li>
                             </ul>
                             <blockquote class="quote-secondary">
                                        <small>
                                        <p>
                                        Поле содержание инцидента обязательно для заполнения.<br>
                                        Если инцидент необходимо закрепить на дашборде Дежурных ЭТИ№1 - установите чекбокс "Закрепить на панели". <br><b>Все новые инциденты желательно закреплять!</b>
                                        </p>
                                        </small>
                             </blockquote>
                             <h6>
                                 Редактирование инцидента
                             </h6>
                             <ul>
                                 <li>
                                     Инциденты -> Выбираем нужный инцидент -> Редактировать
                                     <img src="/dist/img/doc1/42.png" class="img-fluid mb-2" alt="red sample">
                                 </li>
                             </ul>
                             <h6>
                             Закрытие инцидента
                             </h6>
                             <ul>
                                 <li>
                                     Инциденты -> Выбираем нужный инцидент -> Редактировать. Далее изменяем статус на <b>"ЗАКРЫТО"</b>. Инцидент изменит статус на "Закрыто", сразу не исчезнет, но не будет перемещен в следующую смену</b>
                                     <div class="alert alert-danger alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">?</button>
                                       Важно! Нельзя удалять инциденты, новости, задания. Закрытие инцидента осуществляется путем изменение его статуса на "Закрыто".
                                    </div>
                                 </li>
                             </ul>

                            <a name="topic14"></a> </br>
                           <h5>Раздел новости</h5>
                           См. пункт инструкции "Раздел инциденты". Функционал аналогичен
                           <br>

                           <a name="topic15"></a> </br>
                           <h5>Раздел задания</h5>
                           См. пункт инструкции "Раздел инциденты". Функционал аналогичен, за исключением того, что в форме создания задания возможно указать поле"Исполнитель". В таком случае, задание будет видимо только для указанного пользователя.
                           <br>

                           <a name="topic16"></a> </br>
                           <h5>Раздел загрузки</h5>
                           Загрузить -> выбираем файл. Загруженный файл отобразиться в разделе "Недавно загруженные файлы"
                           <img src="/dist/img/doc1/43.png" class="img-fluid mb-2" alt="red sample">
                           <br>

                           <a name="topic16"></a> </br>
                           <h5>Уведомления</h5>
                           Раздел содержит все новый инциденты / новости / задания / поступления дисков, которые были созданы с момента последней ВАШЕЙ смены (т.е., если вы не открывали свою смену 2 недели - вы увидите все новые инциденты за это время).
                           <br>Также уведомления отображаются в верхнем блоке навигации.
                           <img src="/dist/img/doc1/44.png" class="img-fluid mb-2" alt="red sample">
                           <br>

                           <a name="topic17"></a> </br>
                           <h5>Профиль пользователя</h5>
                           Раздел содержит общий чат Дежурных ЭТИ№1 а также Инциденты, Новости, Задания, Операции с дисками, Загрузки выполненные авторизованным пользователем.
                           <br>Также возможно отфильтровать информацию выше по любому пользователю.
                           <blockquote class="quote-secondary">
                                        <small>
                                        <p>
                                            Раздел "Профиль пользователя" может быть удобен для просмтора активностей какого-либо пользователя в системе Журналирования инцидентов дежурных.
                                        </p>
                                        </small>
                            </blockquote>
                           <img src="/dist/img/doc1/45.png" class="img-fluid mb-2" alt="red sample">
                           <br>

                           

                </div>
                <div class="tab-pane fade" id="link2" role="tabpanel" aria-labelledby="vert-tabs-profile-tab">
                    <h4>Описание системы "Учет дисков"</h4>
                    <h5>Назначение системы:</h5>
                    Система учета дисков предназначена для систематизации информации о наличие дисков на складе, их состоянии, а также учета и хранения информации о движении дисков (перемещение между IBS-Складом-Отделом ОБ).
                    <br>
                    Описание функционала и руководство по работе с системой смотрите в пункте <b>"Бизнес процесс учета дисков"</b> текущего глоссария.
                </div>
                <div class="tab-pane fade" id="link3" role="tabpanel" aria-labelledby="vert-tabs-messages-tab">    
                    <h4>
                    Описание процесса движения дисков. 
                    </h4>   
                    <img src="/dist/img/block_schema.png" class="img-fluid mb-2" alt="red sample" width="100%">
                    <blockquote class="quote-secondary">
                    <h5>В каждый момент времени диск имеет определенный статус / состояние:</h5>  
                        <small>
                        <ul>
                            <li>
                                На складе (состояние: <span style="color:green;">новый</span>, <span style="color:saddlebrown;">сломан </span>, <span style="color:grey;">б/у</span>)
                            </li>
                            <li>
                                В ЦОДе (состояние: в работе)
                            </li>
                            <li>
                                В ОБ (сосотояние: сломан, уничтожен)
                            </li>
                            <li>
                                В IBS (сосотояние: уничтожен)
                            </li>
                        </ul> 
                        </small>
                    </blockquote>

                    <h3>Оглавление</h3>
                    <ol> 
                        <li>
                            <a href="#topic1">Поставка диска IBS (Операция "Приход диска на склад в состоянии НОВЫЙ").</a>
                        </li>
                        <li>
                            <a href="#topic2">Операция расхода нового диска в ЦОД.</a>
                        </li>
                        <li>
                            <a href="#topic3">Операция прихода диска на склад из ЦОДа в состоянии "СЛОМАН".</a>
                        </li>
                        <li>
                            <a href="#topic4">Передача диска в ОБ на уничтожение.</a>
                        </li>
                        <li>
                            <a href="#topic5">Передача диска из ОБ на склад в состоянии уничтожен.</a>
                        </li>
                        <li>
                            <a href="#topic6">Передача уничтоженного диска в IBS.</a>
                        </li>
                        <li>
                            <a href="#topic7">Дополнительная информация. Важно!</a>
                        </li>
                    </ol>
                    <a name="topic1"></a> </br>          
                    <h5>1. Поставка диска IBS (Операция "Приход диска на склад в состоянии НОВЫЙ").</h5>
                    
                    <ul>
                        <li>
                        Дежруный ИТ Москва авторизуется в системе учета дисков под обычной УЗ DPC\n7701-**-***.
                        <img src="/dist/img/doc1/1.png" class="img-fluid mb-2" alt="red sample">
                        </li>
                        <li>
                        Переходим "Учет дисков" -> "ZIP", ищем необходимый шаблон диска. При необходимости можно воспользоваться поиском. Если необходимый шаблон диска отсутствует в списке, необходимо его создать, руководствуясь инструкцией "Создание нового шаблона диска"
                        <img src="/dist/img/doc1/2.png" class="img-fluid mb-2" alt="red sample">
                        </li>

                        <li>
                        Проверяем, что в системе нет диска с этим серийным номером, воспользовавшись формой поиска по серийному номеру.
                        <img src="/dist/img/doc1/5.png" class="img-fluid mb-2" alt="red sample">
                        <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">?</button>
                        <h5><i class="icon fas fa-info"></i> Важно!</h5>
                        Выполнять проверку диска по серийному номеру перед добавлением нового диска крайне важно, т.к. серийный номер диска должен уникально идентифицировать диск в системе и не может повторяться. Если не найден диск - можно выполнять операцию добавления. Если найден - диск был добавлен ранее.
                        </div>
                        </li>

                        <li>
                        Приход, заполняем форму данными, сохранить.                        
                        <img src="/dist/img/doc1/6.png" class="img-fluid mb-2" alt="red sample">
                        <blockquote class="quote-secondary">
                        <small>
                            <p>Если необходимо указать несколько серийных номеров дисков - указывайте через пробел, вида: ****s/n1***** *****s/n2****</p>
                            <p>Поле "Серийный номер" обязательно для заполнения. </p>
                            </small>
                        </blockquote>
                        </li>

                        <li>
                        Диск добавлен на склад в состоянии "НОВЫЙ".                         
                        <img src="/dist/img/doc1/7.png" class="img-fluid mb-2" alt="red sample">
                        </li>       
                    </ul>

                    <h5>Замена диска</h5>
                    <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">?</button>
                                Замена диска по своей сути представляется 2-мя операциями (см. схему): 
                                <p>2. Операция расхода диска в ЦОД (в то самое расположение, откуда мы забрали сломанный диск)</p>
                                <p>3. Операция прихода диска на склад в состоянии "СЛОМАН" - т.к. мы поплоняем склад, пусть и сломанным диском.</p>                     
                     </div>
                    
                     <a name="topic2"></a> </br>   
                     <h5>2. Операция расхода нового диска в ЦОД</h5>
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">?</button>
                                Операцию "Расход диска в ЦОД" можно выполнить для любого диска, который находится на складе и имеет состояние "НОВЫЙ".
                            </div> 
                        <ul>
                           
                            <li>                 
                              Ищем диск, который мы намереваемся расходовать в ЦОД. Для этого можно либо пройти по пути: ZIP-> необходимый шаблон диска-> серийный номер нужного диска, либо воспользоваться формой поиска (см. скриншот)
                              <img src="/dist/img/doc1/10.png" class="img-fluid mb-2" alt="red sample">   
                            </li>
                            <li>
                               Если диск находится в статусе "НА СКЛАДЕ" и в состоянии "НОВЫЙ" будет доступна кнопка "Расход". Нажимаем ее и заполняем форму необходимыми данными. Сохранить. 
                               <img src="/dist/img/doc1/11.png" class="img-fluid mb-2" alt="red sample"> 
                               <blockquote class="quote-secondary">
                                <small>
                                    <p>Поля "Тип оборудования", "ИСН", "Комната", "Стойка", "Юнит", "Номер диска" обязательны для заполнения.</p>
                                    </small>
                                </blockquote>  
                            </li>
                            <li>
                            Готово, операция расхода диска в ЦОД выполена, диск имеет статус "В ЦОДе", состояние ""В работе
                               <img src="/dist/img/doc1/12.png" class="img-fluid mb-2" alt="red sample">   
                            </li>                        
                        </ul> 

                    <a name="topic3"></a> </br>   
                    <h5>3. Операция прихода диска на склад из ЦОДа в состоянии "СЛОМАН".</h5>
                        <ul>
                            <li>                  
                                <p>Операция прихода диска на склад из ЦОДа в состоянии "СЛОМАН" выполняется аналогично рассмотренному выше, за исключением заполнения данных формы, см. скриншот</p>
                                <p>Точка поступления: <b style="color:red;"> из ЦОД</b></p>
                                <p>Серийны номер нового диска, установленного вместо вышедшего из строя (S/n диска из п.2)</p>
                                <img src="/dist/img/doc1/8.png" class="img-fluid mb-2" alt="red sample"> 
                            </li>
                            <li>
                                Готово. Добавлен диск на склад из ЦОД в остоянии "СЛОМАН". 
                                <img src="/dist/img/doc1/9.png" class="img-fluid mb-2" alt="red sample"> 
                            </li>
                            <br>
                            <h6>3.1 Проверка корректности связи серийных номеров нового / старого диска</h6>
                            
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">?</button>
                                Крайне необходимо проверять, корректно ли указан серийный номер нового диска при выполнении операции прихода диска на склад из ЦОДа. Иначе не будет корректно сформированы данные для печати "заявления диска на вынос", да и просто, эта информация должна быть зафиксирована в системе. Как это проверить - описано ниже.
                            </div> 
                                <li>Переходим на внутреннюю страницу диска, для которого была выполнена операция "приход диска на склад из ЦОДа". Т.е. тот диск мы переместили из ЦОДа на склад как сломанный.
                                Здесь мы должны увидеть следующую информацию (см. скриншот).
                                <img src="/dist/img/doc1/13.png" class="img-fluid mb-2" alt="red sample"> 
                                Это означает, что новый / сломанный диски связанны корректно по серийному номеру.<br>
                                </li>
                                <li>
                                Если мы видим иформацию как ниже - диски связанны не корректно (в качестве s/n диска, который был указан как диск уставноленный вместо вышедшего из строя указан s/n котоого не существует в системе )
                                <img src="/dist/img/doc1/14.png" class="img-fluid mb-2" alt="red sample"> 
                                Диски связанны не корренктно, необходимо редактировать поле "Серийный номер диска установленного взамен вышедшего из строя" (см. скриншот ниже).
                                <img src="/dist/img/doc1/15.png" class="img-fluid mb-2" alt="red sample">
                                </li>
                        </ul>
                    
                    <a name="topic4"></a> </br>   
                    <h5>4. Передача диска в ОБ на уничтожение.</h5>    
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">?</button>
                          Операцию "передача диска в ОБ на уничтожение" можно выполнить для любого диска, который имеет статус "НА СКЛАДЕ" и состояние "СЛОМАН".
                    </div> 
                    <ul>       
                    <li>
                    Переходим на внутреннюю страницу диска, который нужно переместить в ОБ для уничтожения.
                    <img src="/dist/img/doc1/16.png" class="img-fluid mb-2" alt="red sample">
                    </li>

                    <li>
                    Нажимаем "Печать заявления на вынос". Получаем "Заявление на вынос диска" в распечатанном виде.
                    Далее нажимаем "Передать в ОБ на уничтожение".
                    <img src="/dist/img/doc1/17.png" class="img-fluid mb-2" alt="red sample">
                    <img src="/dist/img/doc1/23.png" class="img-fluid mb-2" alt="red sample">
                    <img src="/dist/img/doc1/24.png" class="img-fluid mb-2" alt="red sample">
                    </li>

                   <li>
                    Проверяем на корректность "Заявление на вынос диска", подписываем заявление у начальника отдела ЭТИ№1. Относим "физически" диск + подписанное заявление на вынос в отдел ОБ.
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">?</button>
                        Важно исключить случаи, например, когда отнесли диск в ОБ (ногами) и не отметили этот факт в системе, или наоборот. Так нельзя вести учет.
                    </div>
                    </li>
                    <li>
                    Готово, диск передан в ОБ на уничтожение. В соответствующих полях можно видеть, что статус диска теперь "В ОБ", и была выполнена операция "Перемещение в ОБ (см. скриншот ниже).
                    <img src="/dist/img/doc1/18.png" class="img-fluid mb-2" alt="red sample">
                    <blockquote class="quote-secondary">
                        <small>
                        <p>Теперь остается только ждать, когда ОБ выполнят операцию уничтожения диска и отметят это в системе (подробнее в п.5 текущей инструкции).</p>
                        </small>
                    </blockquote>
                    </li>  
                    </ul>   

                    <a name="topic5"></a> </br>  
                    <h5>5. Передача диска из ОБ на склад в состоянии уничтожен.</h5> 
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">?</button>
                          Операцию "Передача диска из ОБ на склад в состоянии уничтожен" можно выполнить для любого диска, который имеет статус "В ОБ" и состояние "УБИТ".
                          Диск полчает состояние "УБИТ" когда ОБ выполнит операцию "Уничтожения диска ОБ" в системе учета дисков.
                    </div> 
                    <ul>   
                        <li>
                            Следить за состоянием дисков, которые переданы в ОБ можно в разделе "В ОБ" системы учета дисков.<br>
                            Диски, над которыми уже выполнена операция уничтожения выделены красным цветом, имеют статус "УБИТ" и мы можем забрать такие диски обратно на склад для этого:</br>
                            Идем в ОБ и "физически" перемещаем диск на склад. 
                            Далее возвращаемся в систему учета дисков и для каждого диска выполняем операцию "Передача диска из ОБ на склад в состоянии уничтожен", выбирая в меню диска "Забрать диск из ОБ на склад".
                            <img src="/dist/img/doc1/20.png" class="img-fluid mb-2" alt="red sample">
                        </li>  
                        <li>
                            Все, диск перемещен на склад. Теперь его можно найти в разделе "На складе(сломанные)" в статусе "УБИТ" и выполнить операцию "Передача уничтоженного диска в IBS" (п.6 текущей инструкции)
                        </li>
                    </ul>  
                        
                    <a name="topic6"></a> </br>   
                    <h5>6. Передача уничтоженного диска в IBS.</h5> 
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">?</button>
                          Операцию "Передача уничтоженного диска в IBS" можно выполнить для любого диска, который имеет статус "На складе" и состояние "УБИТ".
                    </div> 
                    <ul>   
                        <li>
                            Следить за дисками, готовыми для передачи в IBS в убитом состоянии можно в разделе "На складе(сломанные)".
                            Для передачи диска в IBS выбираем в меню диска "Передать в IBS".
                            <blockquote class="quote-secondary">
                                <small>
                                <p>Поле "Клмментарий" обязательно для заполнения. Его необходимо заполнить ФИО сотрудника IBS, который получил запчасти.</p>
                                </small>
                             </blockquote>
                            <img src="/dist/img/doc1/21.png" class="img-fluid mb-2" alt="red sample">
                        </li>  
                        <li>
                            Все, уничтоженный диск передан в IBS. Теперь его можно найти в разделе "В IBS" в статусе "УБИТ". <br>
                            <img src="/dist/img/doc1/22.png" class="img-fluid mb-2" alt="red sample">
                            Больше никаких операций с диском выполнить невозможно. <b>Бизнес процесс жизни диска окончен. Мы будем помнить его вечно.</b>
                        </li>
                    </ul> 

                    <a name="topic7"></a> </br>   
                    <h5>7. Дополнительная информация. Важно!</h5> 
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">?</button>
                        <h6>Удаление / Редактирование дисков / шаблонов дисков</h6>
                          Вы можете видеть кнопки удаления / редактирования для дисков / шаблонов дисков. Они сделаны в целях упрощения наполнения БД данными на начальном этапе. В процессе работы ЗАПРЕЩЕНО их использовать. Все статусы, состояния и иные данные должны изменяться только при помощи кнопок движения (Передать в IBS, Расход диска в ЦОД, Передать в ОБ на уничтожение и т.д.)
                          <br>                         
                    </div> 

                </div>
                <div class="tab-pane fade" id="link4" role="tabpanel" aria-labelledby="vert-tabs-messages-tab">
                    <h5>Добавление нового шаблона диска</h4>
                            <ul>
                                <li>
                                    Дежруный ИТ Москва авторизуется в системе учета дисков под обычной УЗ DPC\n7701-**-***. <br>
                                    <img src="/dist/img/doc1/1.png" class="img-fluid mb-2" alt="red sample">
                                </li>

                                <li>
                                    Переходим "Учет дисков" -> "ZIP"    
                                    <img src="/dist/img/doc1/26.png" class="img-fluid mb-2" alt="red sample">
                                </li>
                               
                        
                                <li>  
                                Проверяем, что в системе нет шаблона диска с таким  парт-номером, воспользовавшись формой поиска по парт-номеру .
                                <img src="/dist/img/doc1/27.png" class="img-fluid mb-2" alt="red sample">
                                <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">?</button>
                                <h5><i class="icon fas fa-info"></i> Важно!</h5>
                                Выполнять проверку диска по парт-номеру перед добавлением нового шаблона диска крайне важно, т.к. парт номер диска должен уникально идентифицировать диск в системе и не может повторяться. Если не найден шаблон диска по парт-номеру - можно выполнять операцию добавления. Если найден - шаблон диска был добавлен ранее.
                                </div>
                                </li>

                                <li>
                                "Создать новую номенклатуру диска"
                                <img src="/dist/img/doc1/26.png" class="img-fluid mb-2" alt="red sample">
                                </li>

                                <li>
                                Заполняем форму всеми необходимыми данными -> Сохранить
                                <img src="/dist/img/doc1/28.png" class="img-fluid mb-2" alt="red sample">
                                <blockquote class="quote-secondary">
                                    <small>
                                        <p>Все полня формы обязательны к заполнению, кроме поля "комментарий"</p>
                                    </small>
                                </blockquote>
                                </li>
                                <li>
                                Готово. Создан новый шаблон диска. Теперь можно добавлять в систему диски в данный шаблон.
                                <img src="/dist/img/doc1/26.png" class="img-fluid mb-2" alt="red sample">
                                </li>
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">?</button>
                                    <h6>Удаление / Редактирование шаблонов дисков</h6>
                                    В процессе работы ЗАПРЕЩЕНО удалять / редактировать шаблоны дисков. Кнопки созданы для упрощения начального наполнения БД данными.
                                    <br>                         
                                </div>
                            </ul>
                </div>

                <div class="tab-pane fade" id="link5" role="tabpanel" aria-labelledby="vert-tabs-messages-tab">
                <h5>Инструкция "Уничтожение диска ОБ"</h4>
                    <ul>
                        <li>
                            Администратор ИБ авторизуется в системе учета дисков под обычной УЗ DPC\n7701-**-*** <br>
                            <img src="/dist/img/doc1/1.png" class="img-fluid mb-2" alt="red sample">
                        </li>
                        <li>
                            После авторизации Администратор ИБ автоматически перенаправляется на дашборд "Панель ОБ" (на другие страницы доступ для Администратора ОБ ограничен) <br>
                            <img src="/dist/img/doc1/31.png" class="img-fluid mb-2" alt="red sample">
                        </li>
                        <li>
                            В этот дашборд будут поступать диски в статусе "СЛОМАН" (выделен желтым цветом), которые ранее, Дежурный ЭТИ№1 принес в отдел ОБ для уничтожения.<br>
                            <img src="/dist/img/doc1/31.png" class="img-fluid mb-2" alt="red sample">
                        </li>

                        <li>
                            После "физического" уничтожения диска, Администратор ИБ выбирает в всплывающем меню диска "Уничтожить"<br>
                            <img src="/dist/img/doc1/32.png" class="img-fluid mb-2" alt="red sample">
                        </li>
                        <li>
                           Все, диск уничтожен. Статус диска теперь "УБИТ" (выделен красным), дежурный ЭТИ№1 теперь видит, что диск унитожен и вскоре заберет его для дальнейшей передачи в IBS.<br>
                            <img src="/dist/img/doc1/33.png" class="img-fluid mb-2" alt="red sample">
                        </li>
                    </ul>
                    <blockquote class="quote-secondary">
                         <small>
                             <p>Существует возможность "ОТКЛОНИТЬ" уничтожение диска. Для этого в вслывающем меню диска нужно выбрать "ОТКЛОНИТЬ". Таким образом можно вернуть заявку на уничтожение диска не выполняя. </p>
                             <p>Важно! Выполняйте операцию "Отклонение" в системе учета дисков только после того как дежурный ЭТИ№1 забрал диск!</p>
                             <p>В поле "Комментарий укажите причину отклонения заявки, ФИО человека, который забрал диск (если такой есть)"</p>
                         </small>
                   </blockquote>
                        <li>
                           В случае если диск невозможно уничтожить (как в случае с SSD дисками), сотрудник ОБ должен переместить диск на хранение в ОБ.<br>
                            <img src="/dist/img/doc1/46.png" class="img-fluid mb-2" alt="red sample">
                        </li>

                        <li>
                           После этого диск перемещается в соответствующий раздел (диск на хранении в ОБ) и может быть возвращен  в работу по нажатию на кнопку "Вернуть в работу" <br>
                            <img src="/dist/img/doc1/47.png" class="img-fluid mb-2" alt="red sample">
                        </li>

                        

                </div>

                <div class="tab-pane fade" id="link6" role="tabpanel" aria-labelledby="vert-tabs-messages-tab">
                    <h5>Лог расширения функционала</h4>
                            <ul>
                                <li>
                                    <strike>17.01.2021 Добавлена возможность для ОБ оставлять сломанные диски <b>у себя на хранение</b>. Необходимо для учета SSD дисков, для которых на настоящий момент нет процедуры уничтожения и они хранятся в сейфе отедла ОБ..</strike>
                                    <br>
                                    <strike>Диски, которые перемещены на склад ОБ возможно вернуть обратно в работу, после чего возможны стандартные для ОБ процедуры с диском (уничтожение, отклонения заявки)  </strike>       
                                </li>
                                <li>
                                <strike>17.01.2021 Добавлены "Уведомления" в левом меню: Количество новых Инцидентов, Новостей, Заданий, Количество сломанных дисков на складе, Количество сломанных дисков в ОБ.</strike> 
                                </li>
                                <li>
                                <strike>19.01.2021 Добавлена возможность при создании инцидента указывать тип как "Заметка". Этот тип назначается для всех записей, которые не относятся к оборудованию (например, любая информация которую необходимо передать по смене). При ввыводе помечается как "NOTE".</strike> 
                                </li>
                                <li>
                                <strike>19.01.2021 Изменение в профиле пользователя. Теперь все профили открыты для всех пользователей, можно смотреть информацию о созданных инцидентах, новостях, заданиях любого пользователя.</strike> 
                                </li>
                                <li>
                                <strike>19.01.2021 Изменения прав доступа на уровне controll button. Теперь "Супер Пользователь" может создавать / редактировать инциденты.</strike> 
                                </li>
                                <li>
                                <strike>08.03.2021 Добавлена возможность переводить инциденты в ожидание до поределенной даты. После истечения сроков ожидания заявка отображается в Дашборде дежурных.</strike> 
                                </li>
                                <li>
                                <strike>07.04.2021 Исправлены уведомления. Теперь уведомления отображаются в списке маркером "НОВЫЙ"</strike> 
                                </li>
                                <li>
                                <strike>07.04.2021 Добавлена возможность отмечать инцидент / новость маркером "Принято к сведению"</strike> 
                                </li>
                                <li>
                                <strike>12.06.2021 Добавлена возможность УЗ с правами Администратора применять опции ОБ при учете дисков (убить, отклонить, оставить диск на хранении)</strike> 
                                </li>
                                <li>
                                <strike>12.06.2021 Добавлена возможность ставить задания в ожидание</strike> 
                                </li>
                               
                            </ul>
                </div>
 
            </div>
        </div>
    </div>
    