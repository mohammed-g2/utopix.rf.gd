import os
import shutil
import stat
import ftplib
import click
import git
from dotenv import load_dotenv

load_dotenv('.env-python')


def delete_ftp_dirs(ftp: ftplib.FTP):
    def remove_ftp_dir(path):
        for (name, properties) in ftp.mlsd(path=path):
            if name in ['.', '..']:
                continue
            elif properties['type'] == 'file':
                ftp.delete(f'{path}/{name}')
                print('Deleted File:', f'{path}/{name}')
            elif properties['type'] == 'dir':
                remove_ftp_dir(f"{path}/{name}")
        ftp.rmd(path)
        print('Deleted Directory:', path)

    lst = ftp.mlsd()

    for item in lst:
        if item[0] in ['.', '..']:
                continue
        if item[1]['type'] == 'file':
            ftp.delete(item[0])
            print('Deleted File:', item[0])
        else:
            remove_ftp_dir(item[0])


def upload(ftp: ftplib.FTP, path: str):
    """path: path to upload from"""
    for name in os.listdir(path):
        local_path = os.path.join(path, name)
        if os.path.isfile(local_path):
            print('Created File:', name, local_path)
            with open(local_path,'rb') as f:
                ftp.storbinary('STOR ' + name, f)
        elif os.path.isdir(local_path):
            print('Created Directory:', name)

            try:
                ftp.mkd(name)

            # ignore "directory already exists"
            except Exception as e:
                if not e.args[0].startswith('550'): 
                    raise

            print("Moving to:", name)
            ftp.cwd(name)
            upload(ftp, local_path)           
            print("Moving to:", "..")
            ftp.cwd("..")


def remove_folder_with_permission(repo: str):
    for root, dirs, files in os.walk(repo):  
        for dir in dirs:
            os.chmod(os.path.join(root, dir), stat.S_IRWXU)
        for file in files:
            os.chmod(os.path.join(root, file), stat.S_IRWXU)
    shutil.rmtree(repo)


def delete_remote():
    """clear the contents of UPLOAD_TO in remote ftp server."""
    ftp = ftplib.FTP(
        os.environ.get('FTP_SERVER'),
        os.environ.get('FTP_USERNAME'),
        os.environ.get('FTP_PASSWORD'))

    ftp.cwd(os.environ['UPLOAD_TO'])

    delete_ftp_dirs(ftp)
    
    ftp.quit()
    print('Done.')


def clone_repo():
    """clone github repo and clear .git file."""
    print('Cloning repo...')
    try:
        git.Repo.clone_from(os.environ.get('GITHUB_REPO'), 'website')

        print('removing .git folder')
        remove_folder_with_permission(os.path.join('website', '.git'))
        
        print('Done.')
    except Exception as e:
        print(str(e))


def ftp_upload():
    """upload website to remote UPLOAD_TO ftp directory."""
    ftp = ftplib.FTP(
        os.environ.get('FTP_SERVER'),
        os.environ.get('FTP_USERNAME'),
        os.environ.get('FTP_PASSWORD'))

    ftp.cwd(os.environ.get('UPLOAD_TO'))

    print('Uploading...')
    upload(ftp, 'website')
    
    print('Removing source')
    remove_folder_with_permission('website')
    
    ftp.quit()
    print('Done.')


@click.group()
def cli():
    pass


@click.command('delete-remote')
def delete_remote_cmd():
    """clear the contents of UPLOAD_TO in remote ftp server."""
    delete_remote()


@click.command('clone-repo')
def clone_repo_cmd():
    """clone github repo and clear .git file."""
    clone_repo()


@click.command('upload')
def upload_cmd():
    """upload website to remote UPLOAD_TO ftp directory."""
    ftp_upload()


@click.command('streamline')
def streamline_cmd():
    """run all commands."""
    delete_remote()
    clone_repo()
    ftp_upload()


cli.add_command(delete_remote_cmd)
cli.add_command(clone_repo_cmd)
cli.add_command(upload_cmd)
cli.add_command(streamline_cmd)

if __name__ == '__main__':
    cli()
