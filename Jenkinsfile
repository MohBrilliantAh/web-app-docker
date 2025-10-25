pipeline {
    // Tentukan agent (Jenkins worker) yang memiliki akses ke Docker dan Docker Compose
    agent any

    // Mendefinisikan environment variables yang akan digunakan di dalam pipeline
    environment {
        // Nama image yang akan di-build, harus sesuai dengan docker-compose.yml
        DOCKER_IMAGE = 'laravel-calculator-app' 
        // Nama file compose
        DOCKER_COMPOSE_FILE = 'docker-compose.yml'
    }

    stages {
        // ----------------------------------------------------------------------
        // STAGE 1: BUILD IMAGE
        // ----------------------------------------------------------------------
        stage('Build Docker Image') {
            steps {
                script {
                    echo 'Membangun Docker Image untuk Aplikasi Laravel...'
                    // Menggunakan Dockerfile yang sudah Anda buat
                    // Tag image dengan nomor BUILD_ID Jenkins
                    docker.build("${DOCKER_IMAGE}:${env.BUILD_ID}")
                }
            }
        }

        // ----------------------------------------------------------------------
        // STAGE 2: INSTALL DEPENDENCIES (Opsional, jika tidak dilakukan di Dockerfile)
        // Karena kita sudah menginstal Composer di Dockerfile, stage ini lebih
        // fokus pada testing/linting.
        // ----------------------------------------------------------------------
        stage('Testing & Linting') {
            steps {
                script {
                    echo 'Menjalankan Composer Install di container sementara untuk testing...'
                    // Jalankan Composer install dan testing di container sementara 
                    // sebelum deployment final (praktik terbaik)
                    sh "docker run --rm -v \$(pwd):/app -w /app composer install --no-dev --optimize-autoloader"
                    
                    // Contoh menjalankan test Laravel (jika ada unit test)
                    // sh "docker run --rm -v \$(pwd):/var/www/html -w /var/www/html laravel-calculator-app php ./vendor/bin/phpunit"
                }
            }
        }

        // ----------------------------------------------------------------------
        // STAGE 3: DEPLOY/RUN SERVICES
        // ----------------------------------------------------------------------
        stage('Deploy Services') {
            steps {
                script {
                    echo 'Menjalankan dan memperbarui services via Docker Compose...'
                    // Menggunakan docker-compose untuk menjalankan semua service (app, web, db)
                    // --detach: menjalankan di background
                    // --build: memastikan image terbaru digunakan
                    // --up: membuat/memulai container
                    sh "docker-compose -f ${DOCKER_COMPOSE_FILE} up -d"
                    
                    echo 'Deployment Selesai. Aplikasi tersedia di http://localhost'
                }
            }
        }

        // ----------------------------------------------------------------------
        // STAGE 4: POST-DEPLOYMENT (MIGRATION)
        // Stage ini hanya relevan jika Anda memiliki database migration
        // ----------------------------------------------------------------------
        stage('Run Database Migration') {
            steps {
                script {
                    echo 'Menjalankan Migrasi Database...'
                    // Pastikan service 'app' sudah berjalan untuk menjalankan Artisan
                    // exec -T menjalankan perintah di container app tanpa alokasi TTY
                    sh "docker-compose exec -T app php artisan migrate --force"
                }
            }
        }
        
        // ----------------------------------------------------------------------
        // STAGE 5: CLEANUP
        // Membersihkan image yang tidak digunakan untuk menghemat ruang disk
        // ----------------------------------------------------------------------
        stage('Cleanup') {
            steps {
                script {
                    echo 'Membersihkan image dan container lama...'
                    sh "docker system prune -f"
                }
            }
        }
    }
    
    // ----------------------------------------------------------------------
    // POST: Tindakan setelah pipeline selesai (sukses atau gagal)
    // ----------------------------------------------------------------------
    post {
        always {
            echo 'Pipeline Build Selesai.'
        }
        failure {
            echo 'Pipeline GAGAL! Periksa log build.'
        }
        success {
            echo 'Pipeline BERHASIL! Aplikasi sudah running.'
        }
    }
}
