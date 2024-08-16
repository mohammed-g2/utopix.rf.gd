import os
import shutil
import stat
import ftplib
import click
import git
from dotenv import load_dotenv

load_dotenv('.env')

ftp = ftplib.FTP(
    os.environ.get('FTP_SERVER'),
    os.environ.get('FTP_USERNAME'),
    os.environ.get('FTP_PASSWORD'))


def delete_ftp_dirs(ftp):
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


def upload(ftp, path):
    """path: path to upload from"""
    for name in os.listdir(path):
        localpath = os.path.join(path, name)
        if os.path.isfile(localpath):
            print("STOR", name, localpath)
            ftp.storbinary('STOR ' + name, open(localpath,'rb'))
        elif os.path.isdir(localpath):
            print("MKD", name)

            try:
                ftp.mkd(name)

            # ignore "directory already exists"
            except Exception as e:
                if not e.args[0].startswith('550'): 
                    raise

            print("CWD", name)
            ftp.cwd(name)
            upload(ftp, localpath)           
            print("CWD", "..")
            ftp.cwd("..")


def remove_folder_with_permission(repo):
    for root, dirs, files in os.walk(repo):  
        for dir in dirs:
            os.chmod(os.path.join(root, dir), stat.S_IRWXU)
        for file in files:
            os.chmod(os.path.join(root, file), stat.S_IRWXU)
    shutil.rmtree(repo)


@click.group()
def cli():
    pass


@click.command()
def delete_remote():
    ftp.cwd('htdocs')
    delete_ftp_dirs(ftp)
    ftp.quit()
    print('Done.')


@click.command('clone-repo')
def clone_repo():
    print('Cloning repo...')
    try:
        git.Repo.clone_from(os.environ.get('GITHUB_REPO'), 'website')
        print('removing .git folder')
        remove_folder_with_permission(os.path.join('website', '.git'))
        print('Done.')
    except Exception as e:
        print(str(e))


@click.command('upload')
def ftp_upload():
    ftp.cwd('htdocs')
    print('Uploading...')
    upload(ftp, 'website')
    print('Removing source')
    remove_folder_with_permission('website')
    ftp.quit()
    print('Done.')


@click.command('streamline')
def streamline():
    delete_remote()
    clone_repo()
    ftp_upload()


cli.add_command(delete_remote)
cli.add_command(clone_repo)
cli.add_command(ftp_upload)
cli.add_command(streamline)

if __name__ == '__main__':
    cli()
