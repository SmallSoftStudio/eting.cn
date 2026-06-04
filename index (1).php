<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <link rel="icon" href="eting.cn.logo.svg" type="image/svg+xml">
    <title>艺听 · 一个人的播放器</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            background: radial-gradient(circle at 20% 30%, #0b1a2e, #03070f);
            font-family: 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
            padding: 10px;
        }

        .container {
            width: 85%;
            max-width: 680px;
            margin: 0 auto;
            background: rgba(240, 240, 240, 0.92);
            padding: 1.5rem 1.2rem;
            border-radius: 24px;
            background-image: linear-gradient(135deg, rgba(253, 203, 241, 0.85), rgba(168, 237, 234, 0.85), rgba(210, 153, 194, 0.85));
            backdrop-filter: blur(1px);
            box-shadow: 0 25px 45px rgba(0, 0, 0, 0.3), 0 0 0 1px rgba(255,255,255,0.2) inset;
            position: relative;
            overflow: hidden;
        }

        .eting-badge {
            position: absolute;
            top: 0;
            right: 0;
            background: rgba(100, 100, 120, 0.25);
            backdrop-filter: blur(4px);
            padding: 6px 16px 6px 16px;
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 1px;
            color: #5a6e7a;
            border-radius: 0 24px 0 60px;
            font-family: monospace;
            transition: all 0.2s ease;
            border-left: 1px solid rgba(255,255,255,0.3);
            border-bottom: 1px solid rgba(255,255,255,0.3);
        }

        @media (max-width: 640px) {
            .container {
                padding: 1.5rem 1.2rem;
                width: 100%;
            }
        }

        .container h3 {
            font-size: 1.3rem;
            text-align: center;
            letter-spacing: -0.5px;
            background: linear-gradient(130deg, #0a2b3b, #1b4f6e);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
            margin-bottom: 0.25rem;
            margin-top: 0.25rem;
            font-weight: 700;
        }

        .container > p {
            font-size: 0.9rem;
            color: #1e2f3a;
            margin: 0.2rem 0 1.5rem 0;
            line-height: 1.4;
            font-weight: 500;
            text-align: left;
            letter-spacing: 1px;
        }

        .player-container {
            margin: 20px 0;
        }

        .category-tabs {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 20px;
            border-bottom: 1px solid rgba(0,0,0,0.1);
            padding-bottom: 12px;
        }
        .category-tab {
            padding: 6px 16px;
            border-radius: 30px;
            background: rgba(255,255,255,0.5);
            cursor: pointer;
            font-size: 0.85rem;
            font-weight: 500;
            transition: all 0.2s;
            color: #1e2f3a;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .category-tab:hover {
            background: rgba(255,255,255,0.8);
        }
        .category-tab.active {
            background: #1b4f6e;
            color: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }
        .delete-cat {
            cursor: pointer;
            font-size: 12px;
            opacity: 0.6;
        }
        .delete-cat:hover {
            opacity: 1;
        }
        .plus-btn {
            background: rgba(100,100,120,0.2);
            font-weight: bold;
        }
        .plus-btn.drag-over {
            background: rgba(27, 79, 110, 0.3);
            transform: scale(1.02);
        }

        .now-playing {
            background: rgba(255,255,255,0.4);
            border-radius: 20px;
            padding: 15px;
            margin-bottom: 20px;
            text-align: center;
        }
        .song-title-large {
            font-size: 1.2rem;
            font-weight: 600;
            color: #0c3346;
            margin-bottom: 5px;
        }
        .song-artist {
            font-size: 0.8rem;
            color: #666;
            margin-bottom: 12px;
        }
        audio {
            width: 100%;
            border-radius: 30px;
            outline: none;
        }

        .mode-buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 12px;
        }
        .mode-btn {
            background: rgba(255,255,255,0.8);
            border: 1px solid #ddd;
            border-radius: 30px;
            padding: 4px 16px;
            cursor: pointer;
            font-size: 12px;
            transition: all 0.2s;
        }
        .mode-btn:hover {
            background: rgba(255,255,255,1);
            transform: scale(1.02);
        }
        .mode-btn.active {
            background: #1b4f6e;
            color: white;
            border-color: #1b4f6e;
        }

        .playlist {
            max-height: 200px;
            overflow-y: auto;
        }
        .playlist-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 6px 0;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            cursor: pointer;
            font-size: 0.9rem;
        }
        .playlist-item:hover {
            color: #1b4f6e;
        }
        .playlist-item.active {
            font-weight: 600;
            color: #1b4f6e;
        }
        .playlist-info {
            flex: 1;
        }
        .playlist-duration {
            font-size: 0.7rem;
            color: #aaa;
        }
        .playlist::-webkit-scrollbar {
            width: 3px;
        }
        .playlist::-webkit-scrollbar-track {
            background: transparent;
        }
        .playlist::-webkit-scrollbar-thumb {
            background: rgba(0,0,0,0.15);
            border-radius: 3px;
        }

        .container h4 {
            font-size: 0.8rem;
            font-weight: 600;
            color: #003153;
            padding-top: 12px;
            margin-top: 10px;
            text-align: right;
        }
        a {
            color: #1f7a3a;
            text-decoration: none;
            border-bottom: 1px dotted #4caf7a;
        }
        a:hover {
            color: #0e5429;
        }
        
                .copyright {
            font-size: 0.75rem;
            color: #6a7b86;
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 0.8rem;
            border-top: 1px solid rgba(0,0,0,0.08);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="eting-badge"><strong>eting.cn</strong></div>
        <h3><img src="eting.cn.logo.svg" alt="icon" style="width: 28px; height: 28px; display: inline-block; vertical-align: top; margin-right: 8px;">艺听 · 一个人的播放器</h3>
        <div class="player-container">
            <div class="category-tabs" id="categoryTabs"></div>
            <div class="now-playing">
                <div class="song-title-large" id="nowTitle">点击“+”选择喜爱的音频</div>
                <div class="song-artist" id="nowArtist"></div>
                <audio id="audioPlayer" controls preload="metadata"></audio>
                <div class="mode-buttons">
                    <button class="mode-btn" id="modeOrderBtn">🔁 顺序</button>
                    <button class="mode-btn" id="modeRepeatBtn">🔂 单曲</button>
                    <button class="mode-btn" id="modeRandomBtn">🔀 随机</button>
                </div>
            </div>

            <div class="playlist" id="playlist"></div>
        </div>
        <h4 id="adBanner">卖米求荣：加载中...</h4>
        <div class="copyright">&copy;<?php echo date("Y");?> 您可以由此链接 <a href=" https://github.com/smallsoftstudio/eting.cn"  target="_blank">https://github.com/smallsoftstudio/eting.cn</a> 获得项目完整源代码。</div>
    </div>

    <script>
        (function() {
            // ========== 出售域名列表（可自由增减） ==========
            const forSaleDomains = [
                { name: "ClawSolid.com", url: "https://www.namesilo.com/marketplace/buynow/clawsolid.com", desc: "工业级智能体" },
                { name: "iov.net", url: "https://www.namesilo.com/marketplace/buynow/iov.net", desc: "车联网 · 顶级域名" },
                { name: "leza.com", url: "https://www.namesilo.com/marketplace/buynow/leza.com", desc: "CVCV · 极品四字母" },
                { name: "tuuv.com", url: "https://www.namesilo.com/marketplace/buynow/tuuv.com", desc: "TUUV · 便宜甩卖" },
                { name: "nool.com", url: "https://www.namesilo.com/marketplace/buynow/nool.com", desc: "OO款 · 极品四字母" },
                { name: "vaiv.com", url: "https://www.namesilo.com/marketplace/buynow/vaiv.com", desc: "双V极速 · AI智芯" },
                { name: "viov.com", url: "https://www.namesilo.com/marketplace/buynow/viov.com", desc: "品牌域名 · 极品四字母" }
            ];

            // 轮播间隔（毫秒），默认 30 秒
            const ROTATE_INTERVAL = 30000;

            let rotateTimer = null;

            // 随机获取一个域名
            function getRandomAdDomain() {
                const idx = Math.floor(Math.random() * forSaleDomains.length);
                return forSaleDomains[idx];
            }

            // 渲染广告横幅
            function renderAdBanner(ad) {
                const h4 = document.getElementById('adBanner');
                if (h4 && ad) {
                    h4.innerHTML = `卖米求荣：<a href="${ad.url}" target="_blank" rel="noopener noreferrer">${ad.name} | ${ad.desc}</a>`;
                }
            }

            // 随机切换广告
            function rotateAd() {
                const newAd = getRandomAdDomain();
                renderAdBanner(newAd);
            }

            // 启动定时轮播
            function startAdRotator() {
                if (rotateTimer) clearInterval(rotateTimer);
                rotateTimer = setInterval(rotateAd, ROTATE_INTERVAL);
            }

            // 停止定时轮播（页面卸载时可选）
            function stopAdRotator() {
                if (rotateTimer) {
                    clearInterval(rotateTimer);
                    rotateTimer = null;
                }
            }

            // ========== 播放器核心代码（保持不变） ==========
            let allCategories = [];
            let currentCategoryId = null;
            let currentSongs = [];
            let currentIndex = 0;
            let playMode = 0;
            let audio = null;
            let nextLocalId = 1;

            function generateId() {
                return 'local_' + (nextLocalId++);
            }

            function formatButtonName(rawName) {
                let cleaned = rawName.replace(/[《》【】「」『』〈〉（）()\[\]{}<>!@#$%^&*|\\/?,.:;'"~`！？。，；：“”‘’]/g, '');
                cleaned = cleaned.trim();
                if (cleaned.length >= 4) return cleaned.substring(0, 4);
                if (cleaned.length === 1) return cleaned + '听艺';
                if (cleaned.length === 2) return cleaned + '艺听';
                if (cleaned.length === 3) return cleaned + '听';
                return '艺听';
            }

            function loadServerCategories() {
                return fetch('/audio-api.php')
                    .then(response => response.json())
                    .then(data => {
                        return Object.keys(data).map(name => ({
                            id: 'server_' + name,
                            name: name,
                            type: 'server',
                            songs: data[name].map(song => ({
                                name: song.name,
                                url: song.url,
                                duration: null
                            }))
                        }));
                    })
                    .catch(() => []);
            }

            function renderCategories() {
                const container = document.getElementById('categoryTabs');
                if (!container) return;
                
                let html = '';
                allCategories.forEach(cat => {
                    const activeClass = currentCategoryId === cat.id ? 'active' : '';
                    if (cat.type === 'server') {
                        html += `<div class="category-tab ${activeClass}" data-id="${cat.id}">${escapeHtml(cat.name)}</div>`;
                    } else {
                        const displayText = cat.displayName || formatButtonName(cat.name);
                        html += `<div class="category-tab local ${activeClass}" data-id="${cat.id}" title="${escapeHtml(cat.name)}">
                                    ${escapeHtml(displayText)}
                                    <span class="delete-cat" data-id="${cat.id}" title="移除">✕</span>
                                </div>`;
                    }
                });
                html += `<div class="category-tab plus-btn" id="addFolderBtn" title="点击选择文件夹，或拖拽文件夹到此">+</div>`;
                container.innerHTML = html;
                
                document.querySelectorAll('.category-tab[data-id]').forEach(el => {
                    el.addEventListener('click', (e) => {
                        if (e.target.classList.contains('delete-cat')) return;
                        switchCategory(el.dataset.id);
                    });
                });
                document.querySelectorAll('.delete-cat').forEach(el => {
                    el.addEventListener('click', (e) => {
                        e.stopPropagation();
                        removeLocalCategory(el.dataset.id);
                    });
                });
                
                const addBtn = document.getElementById('addFolderBtn');
                if (addBtn) {
                    addBtn.onclick = () => openFolderSelector();
                    setupDragAndDrop(addBtn);
                }
            }

            function switchCategory(categoryId) {
                const category = allCategories.find(c => c.id === categoryId);
                if (!category) return;
                
                currentCategoryId = categoryId;
                currentSongs = category.songs || [];
                currentIndex = 0;
                renderCategories();
                renderPlaylist();
                
                if (currentSongs.length > 0) {
                    loadSong(0);
                } else {
                    document.getElementById('nowTitle').textContent = "该分类暂无音频";
                    document.getElementById('nowArtist').textContent = "";
                    if (audio) audio.src = "";
                }
            }

            function addLocalCategory(folderName, audioFiles) {
                const exists = allCategories.some(c => c.type === 'local' && c.name === folderName);
                if (exists) {
                    alert(`"${folderName}" 已存在`);
                    return;
                }
                const newCategory = {
                    id: generateId(),
                    name: folderName,
                    displayName: formatButtonName(folderName),
                    type: 'local',
                    songs: audioFiles.map(file => ({
                        name: file.name.replace(/\.(mp3|flac|wav|m4a|ogg)$/i, ''),
                        url: URL.createObjectURL(file),
                        duration: null,
                        rawFile: file
                    }))
                };
                allCategories.push(newCategory);
                renderCategories();
                switchCategory(newCategory.id);
            }

            function removeLocalCategory(categoryId) {
                const category = allCategories.find(c => c.id === categoryId);
                if (!category || category.type !== 'local') return;
                category.songs.forEach(song => {
                    if (song.url && song.url.startsWith('blob:')) URL.revokeObjectURL(song.url);
                });
                const index = allCategories.findIndex(c => c.id === categoryId);
                if (index !== -1) allCategories.splice(index, 1);
                if (currentCategoryId === categoryId) {
                    const firstCat = allCategories[0];
                    if (firstCat) switchCategory(firstCat.id);
                    else {
                        currentCategoryId = null;
                        currentSongs = [];
                        renderPlaylist();
                        document.getElementById('nowTitle').textContent = "暂无音频";
                    }
                }
                renderCategories();
            }

            function openFolderSelector() {
                const input = document.createElement('input');
                input.type = 'file';
                input.webkitdirectory = true;
                input.onchange = (e) => {
                    const files = Array.from(e.target.files);
                    if (files.length === 0) return;
                    const folderName = files[0].webkitRelativePath.split('/')[0];
                    const audioFiles = files.filter(f => f.type.startsWith('audio/') || /\.(mp3|flac|wav|m4a|ogg)$/i.test(f.name));
                    if (audioFiles.length === 0) {
                        alert('该文件夹中没有找到音频文件');
                        return;
                    }
                    addLocalCategory(folderName, audioFiles);
                };
                input.click();
            }

            function setupDragAndDrop(addBtn) {
                addBtn.addEventListener('dragover', (e) => {
                    e.preventDefault();
                    addBtn.classList.add('drag-over');
                });
                addBtn.addEventListener('dragleave', (e) => {
                    e.preventDefault();
                    addBtn.classList.remove('drag-over');
                });
                addBtn.addEventListener('drop', async (e) => {
                    e.preventDefault();
                    addBtn.classList.remove('drag-over');
                    const items = e.dataTransfer.items;
                    let folderName = null;
                    let allAudioFiles = [];
                    async function traverseDirectory(entry, currentFolderName = null) {
                        if (currentFolderName && !folderName) folderName = currentFolderName;
                        if (entry.isFile) {
                            const file = await new Promise(resolve => entry.file(resolve));
                            if (file.type.startsWith('audio/') || /\.(mp3|flac|wav|m4a|ogg)$/i.test(file.name)) {
                                allAudioFiles.push(file);
                            }
                        } else if (entry.isDirectory) {
                            const reader = entry.createReader();
                            const entries = await new Promise(resolve => reader.readEntries(resolve));
                            for (const subEntry of entries) {
                                await traverseDirectory(subEntry, entry.name);
                            }
                        }
                    }
                    for (let i = 0; i < items.length; i++) {
                        const entry = items[i].webkitGetAsEntry();
                        if (entry) await traverseDirectory(entry);
                    }
                    if (!folderName && allAudioFiles.length > 0) {
                        const firstFilePath = allAudioFiles[0].webkitRelativePath;
                        if (firstFilePath) folderName = firstFilePath.split('/')[0];
                    }
                    if (allAudioFiles.length === 0) {
                        alert('请拖拽包含音频文件的文件夹');
                        return;
                    }
                    addLocalCategory(folderName || '我的音乐', allAudioFiles);
                });
            }

            function loadSong(index) {
                if (!currentSongs.length) return;
                const song = currentSongs[index];
                document.getElementById('nowTitle').textContent = song.name;
                document.getElementById('nowArtist').textContent = "";
                if (audio) {
                    audio.src = song.url;
                    audio.load();
                    audio.addEventListener('loadedmetadata', function() {
                        const dur = audio.duration;
                        if (dur && !isNaN(dur) && isFinite(dur)) {
                            const minutes = Math.floor(dur / 60);
                            const seconds = Math.floor(dur % 60);
                            song.duration = `${minutes}:${seconds.toString().padStart(2, '0')}`;
                            renderPlaylist();
                        }
                    }, { once: true });
                }
                renderPlaylist();
            }

            function renderPlaylist() {
                const container = document.getElementById('playlist');
                if (!container) return;
                container.innerHTML = '';
                currentSongs.forEach((song, idx) => {
                    const item = document.createElement('div');
                    item.className = `playlist-item ${idx === currentIndex ? 'active' : ''}`;
                    item.innerHTML = `<div class="playlist-info"><span class="playlist-title">${escapeHtml(song.name)}</span>${song.duration ? `<span class="playlist-duration"> ${song.duration}</span>` : ''}</div>`;
                    item.onclick = () => {
                        currentIndex = idx;
                        loadSong(currentIndex);
                        audio.play().catch(e => console.log("需要用户交互"));
                    };
                    container.appendChild(item);
                });
            }

            function playNext() {
                if (!currentSongs.length) return;
                let nextIndex;
                if (playMode === 2) {
                    do {
                        nextIndex = Math.floor(Math.random() * currentSongs.length);
                    } while (nextIndex === currentIndex && currentSongs.length > 1);
                } else {
                    nextIndex = (currentIndex + 1) % currentSongs.length;
                }
                currentIndex = nextIndex;
                loadSong(currentIndex);
                audio.play();
            }

            function bindModeButtons() {
                const orderBtn = document.getElementById('modeOrderBtn');
                const repeatBtn = document.getElementById('modeRepeatBtn');
                const randomBtn = document.getElementById('modeRandomBtn');
                if (orderBtn) orderBtn.onclick = () => { playMode = 0; updateModeButtons('order'); };
                if (repeatBtn) repeatBtn.onclick = () => { playMode = 1; updateModeButtons('repeat'); };
                if (randomBtn) randomBtn.onclick = () => { playMode = 2; updateModeButtons('random'); };
                updateModeButtons('order');
            }

            function updateModeButtons(activeMode) {
                ['modeOrderBtn', 'modeRepeatBtn', 'modeRandomBtn'].forEach(id => {
                    document.getElementById(id)?.classList.remove('active');
                });
                if (activeMode === 'order') document.getElementById('modeOrderBtn')?.classList.add('active');
                else if (activeMode === 'repeat') document.getElementById('modeRepeatBtn')?.classList.add('active');
                else if (activeMode === 'random') document.getElementById('modeRandomBtn')?.classList.add('active');
            }

            function escapeHtml(text) {
                if (!text) return '';
                const div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            }

            function init() {
                audio = document.getElementById('audioPlayer');
                if (!audio) return;
                
                loadServerCategories().then(serverCats => {
                    allCategories = serverCats;
                    if (allCategories.length > 0) {
                        currentCategoryId = allCategories[0].id;
                        currentSongs = allCategories[0].songs;
                        renderCategories();
                        renderPlaylist();
                        if (currentSongs.length > 0) loadSong(0);
                    } else {
                        renderCategories();
                    }
                });
                
                audio.addEventListener('ended', () => {
                    if (playMode === 1) {
                        audio.currentTime = 0;
                        audio.play();
                    } else {
                        playNext();
                    }
                });
                
                bindModeButtons();
                
                // 初始化广告：随机显示一个，并启动 30 秒轮播
                const initialAd = getRandomAdDomain();
                renderAdBanner(initialAd);
                startAdRotator();
            }

            // 可选：页面关闭时清理定时器（非必须，但有利于资源释放）
            window.addEventListener('beforeunload', function() {
                stopAdRotator();
            });

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', init);
            } else {
                init();
            }
        })();
    </script>
</body>
</html>