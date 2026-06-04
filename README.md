# eting.cn

**English**  
A simple web-based audio player designed for playing your local audio files.

**中文**  
一个简洁的网页音频播放器，专为播放您本地的音频文件而设计。

---

## 🎧 Live Demo / 在线体验

**English**  
Visit [https://eting.cn/index.php](https://eting.cn/index.php) to play audio files directly from your PC or phone.

**中文**  
访问 [https://eting.cn/index.php](https://eting.cn/index.php)，即可在电脑或手机上直接播放您本地的音频文件。

---

## 🚀 Deploy Your Own Player / 部署自己的播放器

### Option 1: if you aleady have a typic webhosting / 如果您已经有一个典型的web服务器

**English**  
Just copy `index.php` into your web hosting directory – that's it.

**中文**  
直接将 `index.php` 上传到您的网站目录即可，无需任何额外配置。

---

### Option 2: Use as Static HTML / 作为静态 HTML 使用

**English**  
If you don't have PHP hosting, simply rename `index.php` to `index.html` – it will work perfectly.

**中文**  
如果您没有支持 PHP 的主机环境，只需将 `index.php` 重命名为 `index.html` 即可直接运行。

---

### Option 3: Full Online Audio Library (PHP Required) / 在线音频库（需要 PHP 环境）

**English**  
If you want to not only play local files but also host your own online audio library, you'll need:

- A PHP-enabled web hosting environment
- Upload `audio-api.php` to your hosting directory
- Create a folder named `/audio` and put your audio files inside it

That's it – your online audio player is ready.

**中文**  
如果您不仅希望播放本地文件，还想托管自己的在线音频库，您需要：

- 一个支持 PHP 的网站运行环境
- 将 `audio-api.php` 上传到您的网站目录
- 创建一个名为 `/audio` 的文件夹，并将您的音频文件放入其中

完成以上步骤后，您的在线音频播放器就可以正常工作了。

---

## 📁 File Overview / 文件说明

| File | Description / 说明 |
|------|-------------------|
| `index.php` | Main player interface / 播放器主界面 |
| `audio-api.php` | API for online audio library / 在线音频库 API（可选） |
| `/audio/` | Directory to store your online audio files / 存放在线音频文件的目录（可选） |

---

## 📝 MIT License / MIT 开源协议

**English**  
Free to use, modify, and share. but remember give us credit.tks

**中文**  
自由使用、修改和分享。记得提示一下您复用了此处的思路或代码
