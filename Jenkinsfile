pipeline(
    agent any
    environment(
        staging_server="ssh.address"
    )

    stages(
        stage('Deploy to Remote')(
            steps(
                sh 'scp -r ${WORKSPACE}/* root@${staging_server}:/path/www/path/folder'
            )
        )
    )
)