import '../css/app.css';
import '../css/buzzer.css';
import './bootstrap';

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

            if (event.status === 'closed') {
                if (closedBox) closedBox.style.display = 'block';
                if (roomContent) roomContent.style.display = 'none';
                return;
            } else {
                if (closedBox) closedBox.style.display = 'none';
                if (roomContent) roomContent.style.display = 'block';
            }

            if (buzzSection && resultSection) {
                if (event.status === 'waiting') {
                    buzzSection.style.display = 'block';
                    resultSection.style.display = 'none';
                } else {
                    buzzSection.style.display = 'none';
                    resultSection.style.display = 'block';
                    renderPlayerCircles(event.players);

                    if (winnerText) {
                        if (event.current_winner_name) {
                            winnerText.style.display = 'block';
                            winnerText.innerHTML = `صاحب أولوية الإجابة: <strong>${event.current_winner_name}</strong>`;
                        } else {
                            winnerText.style.display = 'none';
                        }
                    }
                }
            }
        });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initRealtime);
} else {
    initRealtime();
}