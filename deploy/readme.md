#### deployment commands to upload website via ftp

- change file name `.env-python-example` to `.env-python`
- edit `.env-python` file content
- `python ftp.py delete-remote` delete all files in specified folder on ftp server
- `python ftp.py clone-repo` clone specified repository from github and removes `.git` folder
- `python ftp.py upload` upload the cloned repo to the ftp server
- `python ftp.py streamline` run all previous commands
