pipeline{
  agent any

  environment {
  GIT_CREDENTIALS_ID = 'be0ed972-97ca-4f0f-b31d-c2da6a198b15'
  GIT_URL = 'https://gitlab.amana.dz/exp/command_os.git'
  GIT_BRANCH = 'master'
  SONAR_CREDENTIALS_ID = '71e754a9-1016-44e1-b5c4-1981d09ba2c6'
  SCANNER_HOME = tool 'Scanner_Agent1'
  }

  stages {
    stage('Checkout Git') {
      steps {
        git(credentialsId: GIT_CREDENTIALS_ID, 
        url: GIT_URL,
        branch: GIT_BRANCH)
      }
    }

    stage('Trigger SonarQube Analysis') {
      steps {
        build wait:false, job: 'SonarQube_Global', 
          parameters: [
            string(name: 'GIT_CREDENTIALS_ID', value: GIT_CREDENTIALS_ID),
            string(name: 'GIT_URL', value: GIT_URL),
            string(name: 'GIT_BRANCH', value: GIT_BRANCH),
            string(name: 'UPSTREAM_JOB_NAME', value: env.JOB_NAME)
          ]
      }
    }

    stage('Copy Files to Target Server') {
      steps {
        sshPublisher(
          continueOnError: false,
          failOnError: true,
          publishers: [
            sshPublisherDesc(
              configName: 'Node_Vanguard',
              transfers: [
                sshTransfer(
                  sourceFiles: "*/", // Adjust as per your file pattern
                  remoteDirectory: "lcom/",
                  execTimeout: 120000
                )
              ],
              usePromotionTimestamp: false,
              useWorkspaceInPromotion: false,
              verbose: false
            )
          ]
        )
      }
    }

    stage('Deploy') {
      steps {  
        sshPublisher(
          continueOnError: false,
          failOnError: true,
          publishers: [
            sshPublisherDesc(
              configName: 'Node_Vanguard', 
              transfers: [
                sshTransfer(
                  execCommand: """
                                  cd /opt/docker/lcom
                                  sudo docker compose up --build --detach > /dev/null

                               """,
                  execTimeout: 240000
                )
              ],
              usePromotionTimestamp: false,
              useWorkspaceInPromotion: false,
              verbose: true 
            )
          ]
        )
      }
    }
  }

  post {
    always {
      echo 'Pipeline execution completed'

      emailext(
        attachLog: true,
        body: '$DEFAULT_CONTENT',
        recipientProviders: [culprits()], 
        subject: '$DEFAULT_SUBJECT', 
        to: '$DEFAULT_RECIPIENTS'
      )
    }
    
    failure {
      echo 'Pipeline execution failed'
    }
    
    success {
      echo 'Pipeline execution succeeded'
    }
  }
}