set :application, "website"
set :user,        "www-data"
set :app_path,    "app"

ssh_options[:forward_agent] = true

set :stages, ["prod"]
set :default_stage, "prod"
set :stage_dir,     "app/config/stages"
require 'capistrano/ext/multistage'

set :repository,  "git@github.com:theodo/flattracker-backend.git"
set :scm,         :git

# project config
set :use_composer,          true
set :vendors_mode,          "install"
set :controllers_to_clear,  ["app_*.php"]
set :assets_symlinks,       false
set :assets_relative,       false
set :update_assets_version, true
set :interactive_mode,      false
set :model_manager,         "doctrine"
set :keep_releases,         5
set :symfony_console,       "app/console"

# permissions config
set :writable_dirs,       ["app/cache", "app/logs"]
set :webserver_user,      "www-data"
set :use_set_permissions, false
set :use_sudo,            false

# shared files
set :shared_files,        ["app/config/parameters.yml"]
set :shared_children,     ["app/logs", "vendor"]

# composer settings
set :use_composer,      true
set :update_vendors,    false
set :copy_vendors,      true
set :vendors_mode,      "install"
set :composer_options,  "--no-progress --verbose --prefer-dist --optimize-autoloader"

# assets settings
set :update_assets_version,  true
set :assets_install,         true
set :assets_symlinks,        true
set :assets_relative,        false
set :dump_assetic_assets,    false

# Be more verbose by commenting the following line
logger.level = Logger::MAX_LEVEL

# deployment tasks
before "deploy:create_symlink", "symfony:doctrine:migrations:migrate"
after "deploy:create_symlink", "deploy:cleanup"
