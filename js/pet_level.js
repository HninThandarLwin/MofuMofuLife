document.addEventListener('DOMContentLoaded', function () {

    const modal = document.getElementById('levelUpModal');

    if (!modal) {
        return;
    }
    const levelUpButton =
        document.getElementById('levelUpButton');

    const cancelButton =
        document.getElementById('levelUpCancel');

    const message =
        modal.querySelector('.level-up-message');

    const question =
        modal.querySelector('.level-up-question');

    const currentLevel =
        Number(modal.dataset.level);

    const nextLevel =
        Number(modal.dataset.nextLevel);

    console.log('Current level:', currentLevel);
    console.log('Next level:', nextLevel);
    console.log('Show popup:', modal.dataset.show);

    const isEvolution =
        nextLevel === 10 ||
        nextLevel === 20 ||
        nextLevel === 30;

    function showPopup() {

        if (isEvolution) {
            message.textContent = '告。進化が可能です。';
            question.textContent = '進化しますか？';

            if (levelUpButton) {
                levelUpButton.textContent = '進化する';
            }
        } else {
            message.textContent = '告。レベルアップが可能です。';
            question.textContent = 'レベルアップしますか？';

            if (levelUpButton) {
                levelUpButton.textContent = 'レベルアップする';
            }
        }

        modal.style.display = 'flex';

        const audio = new Audio(
            (
                isEvolution
                    ? './sounds/evolve.mp3'
                    : './sounds/level_up.mp3'
            ) + '?v=' + Date.now()
        );

        audio.play().catch((error) => {
            console.log('Audio could not play:', error);
        });
    }

    if (cancelButton) {
        cancelButton.addEventListener(
            'click',
            function () {
                modal.style.display = 'none';
            }
        );
    }

    if (modal.dataset.show === 'true') {
        showPopup();
    }

    const showLevelUpButton =
        document.getElementById('showLevelUpButton');

    if (showLevelUpButton) {

        showLevelUpButton.addEventListener(
            'click',
            function () {

                fetch('./includes/pet_level.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type':
                            'application/x-www-form-urlencoded'
                    },
                    body: 'show_popup=1'
                })
                    .then(response => response.text())
                    .then(() => {
                        showPopup();
                    });

            }
        );
    }

});