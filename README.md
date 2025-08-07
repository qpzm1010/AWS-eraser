# 🧹 AWS Eraser

AWS 리소스를 안전하고 간편하게 관리하는 웹 기반 도구입니다.  
다중 사용자 환경을 지원하며, 개별 키 관리, 실행 기록, 간단한 인터페이스를 제공합니다.

**🌐 데모 사이트**: [https://aws-eraser.kro.kr/](https://aws-eraser.kro.kr/)

---

## ✨ 주요 기능

- ✅ **사용자 등록 및 로그인** (보안 코드 포함)
- 🔐 **AWS 액세스 키 암호화 저장**
- 🌍 **리전 선택** (서울, 도쿄, 싱가포르, 버지니아, 캘리포니아, 오레곤)
- 💣 **실제 삭제 실행** (확인 후 실행)
- 📦 **실행 상태 추적** (진행 중, 완료 등)
- 📜 **실행 로그 확인**
- 🗃️ **이전 사용 키 관리 및 삭제**
- 🌙 **다크모드 지원**

---

## 🛠️ 기술 스택

| 분류 | 기술 |
|------|------|
| 언어 | PHP 8.2 |
| 프론트엔드 | HTML5 + CSS3 + JavaScript |
| 백엔드 | PHP-FPM + MySQL 8 |
| 인프라 | Docker, Nginx |

---

## 📁 프로젝트 구조

```
aws-eraser/
├── docker-compose.yml      # Docker Compose 설정
├── Dockerfile              # Docker 이미지
├── init.sql                # 데이터베이스 초기화
├── nginx/                  # Nginx 설정
│   └── default.conf
├── php/                    # PHP 설정
│   └── conf.d/
├── public/                 # 웹 애플리케이션
│   ├── assets/             # CSS, JS, 이미지
│   ├── dashboard.php       # 대시보드
│   ├── login.php           # 로그인
│   ├── register.php        # 회원가입
│   ├── run_nuke.php        # AWS Eraser 실행
│   └── view_log.php        # 로그 확인
└── storage/                # 저장소 (볼륨 마운트)
    ├── configs/            # AWS 설정 파일
    └── logs/               # 실행 로그
```

---

## ⚠️ 주의사항

- **AWS 리소스 삭제 기능**이 있으므로 주의해서 사용하세요
- **중요한 데이터는 반드시 백업**하세요
- **실제 삭제 전에 dry-run**을 권장합니다
- **프로덕션 환경에서는 보안 설정을 강화**하세요

---

## 👨‍💻 개발자

**qpzm1010** - [GitHub](https://github.com/qpzm1010)

프로젝트 링크: [https://github.com/qpzm1010/AWS-eraser](https://github.com/qpzm1010/AWS-eraser)
