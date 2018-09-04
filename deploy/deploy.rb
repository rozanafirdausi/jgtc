# config valid only for Capistrano 3.5
lock '3.10.0'

set :application, 'jgtc-2018'
set :repo_url, 'git@gitlab.com:suitmedia/jazz-goes-to-campus-2018.git'

# Default branch is :master
# ask :branch, proc { `git rev-parse --abbrev-ref HEAD`.chomp }.call

# Default deploy_to directory is /var/www/my_app
# set :deploy_to, '/home/suitmedia/suitevent'

# Default value for :scm is :git
# set :scm, :git

# Default value for :format is :pretty
# set :format, :pretty

# Default value for :log_level is :debug
# set :log_level, :debug

# Default value for :pty is false
# set :pty, true

# Default value for :linked_files is []
set :linked_files, fetch(:linked_files, []).push('.env')

# Default value for linked_dirs is []
set :linked_dirs, fetch(:linked_dirs, []).push('storage/app', 'storage/framework/cache', 'storage/framework/sessions', 'storage/framework/views', 'storage/logs', 'public/files', 'public/uploads', 'public/rawuploads')

# Default value for default_env is {}
# set :default_env, { path: "/opt/ruby/bin:$PATH" }

# Default value for keep_releases is 5
# set :keep_releases, 5

namespace :deploy do

  desc 'Restart application'
  task :restart do
    on roles(:app), in: :sequence, wait: 5 do

      execute "chmod o+w #{release_path.join('bootstrap/cache')} -R"
      execute "chmod o+w #{release_path.join('storage')} -R"
      execute "cd '#{release_path}'; composer install"
      execute "cd '#{release_path}'; composer dump-autoload"
      execute "cd '#{release_path}'; php artisan clear-compiled"
      #execute "cd '#{release_path}'; php artisan optimize"
      execute "cd '#{release_path}'; php artisan migrate -n --force"
      #execute "sudo /usr/sbin/service php7.0-fpm restart"
    end
  end

  desc 'Clearing application cache and restart the queue worker'
  task :clear_cache do
    on roles(:app), in: :sequence do
      execute "cd '#{release_path}'; php artisan cache:clear"
      execute "cd '#{release_path}'; php artisan view:clear"
      execute "cd '#{release_path}'; php artisan queue:restart"
    end
  end

  before :publishing, :restart
  after :restart, :clear_cache

end
