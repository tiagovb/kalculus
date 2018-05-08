<aside class="main-sidebar">

    <section class="sidebar">

        <?= \dmstr\widgets\Menu::widget([
                'items' => [
                    ['icon' => 'home', 'label' => 'Página Principal', 'url' => ['/site/index']],

                    ['icon' => 'send-o', 'label' => 'Contato', 'url' => ['/site/contact']],

                    ['icon' => 'child', 'label' => 'Pessoas', 'url' => ['/pessoa/index']],

                    ['icon' => 'users', 'label' => 'Usuários', 'url' => ['/user/admin']],
                ],
            ]) ?>

    </section>

</aside>
