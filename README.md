#  LAMP Stack Deployment on Kubernetes using Minikube & Ansible

This project automates the deployment of a LAMP (Linux, Apache, MySQL/MariaDB, PHP) stack using:

- Dockerfile for docker images 
- Kubernetes YAML manifests
- Minikube as the Kubernetes cluster
- Ansible to orchestrate the deployment

---

##  Directory Structure

```

task9/lamp/
├── apache-php/            # Contains Dockerfile and index.php (for Apache + PHP)
├── mysql/                 # Contains Dockerfile for MariaDB
├── kubernetes/            # Contains Kubernetes YAML files
└── lamp\_deploy.yml        # Ansible playbook for full automation

````

---

##  Prerequisites

-  Minikube installed and running
-  Docker installed
-  Kubernetes CLI (`kubectl`) configured
-  Ansible installed
-  Docker images already pushed to Docker Hub

---

##  Images Used

Ensure these Docker images are built and pushed to Docker Hub:

- `ashu304/apache-php` — Apache with PHP and your `index.php`
- `ashu304/mysql-image` — MariaDB image with default configs

>  customize the image names in the Kubernetes YAML files.

---

##  Deployment Steps

### 1. Start Minikube

```
minikube start
````

Important note :- since using hostpath  mounting for accessing  index.php from host machine  ,open new terminal and run below command 
--------------------------------------------
minikube mount <path to index.ph>:/mnt/app 
--------------------------------------------
if want to avoid manual uploading index.php and further optimized by copying file into dockerfile and make a custom images and then use emptydir within pod in deployment.yml

### 2. Run the Ansible Playbook on new terminal

```
ansible-playbook lamp_deploy.yml
```

This will:

* Apply Kubernetes manifests (Apache + MariaDB)
* Wait for MariaDB to be ready
* Create a `testdb` database
* Grant access to MariaDB from Apache pod
* Print Apache service URL
* Test the connection internally from Minikube using `curl`

---

## Output

If successful, you will see something like:

```
Apache URL is http://192.168.49.2:30080
...
Trying to connect to mariadb ...
Resolved mariadb to 10.x.x.x
Connected to MariaDB successfully!
```

Copy the URL into your browser to verify!

---

## index.php Sample

Make sure your `index.php` looks like:

```php
<?php
echo "Trying to connect to mariadb ...<br>";

$host = "mariadb";
$user = "root";
$pass = "rootpass";
$db = "testdb";

echo "Resolved mariadb to " . gethostbyname($host) . "<br>";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected to MariaDB successfully!";
?>
```


