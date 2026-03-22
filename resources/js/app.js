import '../css/app.css';
import '../css/buzzer.css';
import './bootstrap';

let playerBuzzSent = false;
let lastWinnerId = null;
let soundUnlocked = false;

function teamColor(teamNumber) {
    switch (Number(teamNumber)) {
        case 1: return '#3b82f6';
        case 2: return '#ef4444';
        case 3: return '#10b981';
        case 4: return '#f59e0b';
        case 5: return '#8b5cf6';
        default: return '#6b7280';
    }
}

function renderAdminPlayers(players) {
    const container = document.getElementById('players-list');
    if (!container) return;

    if (!players.length) {
        container.innerHTML = '<p class="empty-note">لا يوجد لاعبون منضمون حتى الآن.</p>';
        return;
    }

    container.innerHTML = players.map(player => `
        <div class="player-item">
            <div
                class="player-circle ${player.is_winner ? 'winner' : ''}"
                style="background: ${teamColor(player.team_number)};"
            ></div>
            <div class="player-name">${player.name}</div>
            <div class="player-meta">فريق ${player.team_number}</div>
        </div>
    `).join('');
}

function renderPlayerCircles(players) {
    const container = document.getElementById('all-players-state');
    if (!container) return;

    container.innerHTML = players.map(player => `
        <div class="player-item">
            <div
                class="player-circle lg ${player.is_winner ? 'winner' : ''}"
                style="background: ${teamColor(player.team_number)};"
            ></div>
            <div class="player-name" style="font-weight:${player.is_winner ? '700' : '500'};">
                ${player.name}
            </div>
        </div>
    `).join('');
}

const isAdminPage = !!document.body?.dataset?.adminGameId;
const bellSound = isAdminPage ? new Audio('/sounds/bell.mp3') : null;

if (bellSound) {
    bellSound.preload = 'auto';
}

function unlockSound() {
    if (!isAdminPage || !bellSound || soundUnlocked) return;

    bellSound.play()
        .then(() => {
            bellSound.pause();
            bellSound.currentTime = 0;
            soundUnlocked = true;
        })
        .catch(() => {});
}

function playBellSound() {
    if (!isAdminPage || !bellSound) return;

    bellSound.currentTime = 0;
    bellSound.play().catch((error) => {
        console.log('تعذر تشغيل الصوت تلقائيًا:', error);
    });
}

if (isAdminPage) {
    document.addEventListener('click', unlockSound, { once: true });
    document.addEventListener('touchstart', unlockSound, { once: true });
}

function initPlayerBuzz() {
    const buzzButton = document.getElementById('buzz-button');
    if (!buzzButton) return;

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    const buzzUrl = buzzButton.dataset.buzzUrl;
    const buzzNote = document.getElementById('buzz-note');

    async function sendBuzz(event) {
        if (event) {
            event.preventDefault();
        }

        if (playerBuzzSent || !buzzUrl || !csrfToken) return;

        playerBuzzSent = true;
        buzzButton.disabled = true;
        buzzButton.style.pointerEvents = 'none';
        buzzButton.textContent = 'جارٍ الإرسال...';

        if (buzzNote) {
            buzzNote.textContent = 'تم إرسال الضغطة...';
        }

        try {
            const response = await fetch(buzzUrl, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({}),
                credentials: 'same-origin',
                keepalive: true,
            });

            const data = await response.json().catch(() => null);

            if (!response.ok) {
                throw new Error(data?.message || 'تعذر تسجيل الضغطة.');
            }

            if (!data?.accepted && buzzNote) {
                buzzNote.textContent = 'تم استلام الضغطة.';
            }
        } catch (error) {
            playerBuzzSent = false;
            buzzButton.disabled = false;
            buzzButton.style.pointerEvents = '';
            buzzButton.textContent = 'اضغط';

            if (buzzNote) {
                buzzNote.textContent = 'تعذر إرسال الضغطة، حاول مرة أخرى.';
            }

            console.error(error);
        }
    }

    buzzButton.addEventListener('pointerdown', sendBuzz);

    buzzButton.addEventListener('keydown', (event) => {
        if (event.key === 'Enter' || event.key === ' ') {
            sendBuzz(event);
        }
    });
}

function initRealtime() {
    const adminGameId = document.body?.dataset?.adminGameId;
    const playerGameId = document.body?.dataset?.playerGameId;
    const gameId = adminGameId || playerGameId;

    console.log('Realtime init:', {
        adminGameId,
        playerGameId,
        gameId,
        echoExists: !!window.Echo
    });

    if (!gameId || !window.Echo) {
        return;
    }

    window.Echo.channel(`game.${gameId}`)
        .listen('.game.state.updated', (event) => {
            console.log('Realtime event received:', event);

            const shouldPlayBell =
                event.current_winner_id &&
                event.current_winner_id !== lastWinnerId;

            if (shouldPlayBell) {
                playBellSound();
            }

            lastWinnerId = event.current_winner_id || null;

            const winnerBox = document.getElementById('winner-box');
            const winnerName = document.getElementById('winner-name');
            const winnerTeam = document.getElementById('winner-team');

            if (winnerBox) {
                if (event.current_winner_name) {
                    winnerBox.style.display = 'block';

                    if (winnerName) {
                        winnerName.textContent = event.current_winner_name;
                    }

                    const winnerPlayer = event.players.find(p => p.id === event.current_winner_id);

                    if (winnerTeam && winnerPlayer) {
                        winnerTeam.textContent = `فريق ${winnerPlayer.team_number}`;
                    }
                } else {
                    winnerBox.style.display = 'none';
                }
            }

            renderAdminPlayers(event.players);

            const closedBox = document.getElementById('closed-box');
            const roomContent = document.getElementById('room-content');
            const buzzSection = document.getElementById('buzz-section');
            const resultSection = document.getElementById('result-section');
            const winnerText = document.getElementById('winner-text');
            const buzzButton = document.getElementById('buzz-button');
            const buzzNote = document.getElementById('buzz-note');

            if (event.status === 'closed') {
                playerBuzzSent = true;

                if (closedBox) closedBox.style.display = 'block';
                if (roomContent) roomContent.style.display = 'none';
                return;
            } else {
                if (closedBox) closedBox.style.display = 'none';
                if (roomContent) roomContent.style.display = 'block';
            }

            if (buzzSection && resultSection) {
                if (event.status === 'waiting') {
                    playerBuzzSent = false;

                    buzzSection.style.display = 'block';
                    resultSection.style.display = 'none';

                    if (buzzButton) {
                        buzzButton.disabled = false;
                        buzzButton.style.pointerEvents = '';
                        buzzButton.textContent = 'اضغط';
                    }

                    if (buzzNote) {
                        buzzNote.textContent = 'أول ضغطة صحيحة تحصل على أولوية الإجابة';
                    }

                    if (winnerText) {
                        winnerText.style.display = 'none';
                        winnerText.innerHTML = '';
                    }
                } else {
                    playerBuzzSent = true;

                    buzzSection.style.display = 'none';
                    resultSection.style.display = 'block';

                    if (buzzButton) {
                        buzzButton.disabled = true;
                        buzzButton.style.pointerEvents = 'none';
                    }

                    renderPlayerCircles(event.players);

                    if (winnerText) {
                        if (event.current_winner_name) {
                            winnerText.style.display = 'block';
                            winnerText.innerHTML = `صاحب أولوية الإجابة: <strong>${event.current_winner_name}</strong>`;
                        } else {
                            winnerText.style.display = 'none';
                            winnerText.innerHTML = '';
                        }
                    }
                }
            }
        });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        initPlayerBuzz();
        initRealtime();
    });
} else {
    initPlayerBuzz();
    initRealtime();
}