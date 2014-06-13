<?php

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

include_once('setup.inc.php');
include_once('build.inc.php');

$console = new Application('DrupalCI - CommandLine', '0.1');

$app->boot();


/*
 * INIT Command
 *
 * Initializes the drupalci environment, checking for required dependencies,
 * establishing default base environment variables, and generating the default
 * ~/.drupalci directory.
 *
 * Usage: drupalci setup [OPTIONS]
 *
 * Options:
 * --dbtype=<dbtype>   Database types to support.
 *                     Values: mysql, mariadb, pgsql, sqlite, or ALL.
 *                     Default: mysql.
 * --php_version       PHP Versions to support.
 *                     Values: 5.3, 5.4, 5.5, or 5.6
 *                     Default: 5.4
 * --force             Override a previous setup
 *
 // TODO: We should check if the setup is already done. if yes we should ask to use --force
 */

$console
    ->register('init')
    ->setDescription('Setups the Docker Enviroment with sane defaults for testing')
    ->setCode(function (InputInterface $input, OutputInterface $output) use ($app) {
        if (!$distro = getLinuxDistro())
        {
           $output->writeln('<error>ERROR</error>: Could not determine Linux distro');
           exit;
        }
        #$output->writeln('<info>INFO</info>');
        #$output->writeln('<error>ERROR</error>');
        $output->writeln("<info>INFO</info>: Running on $distro");
        $output->writeln("<info>INFO</info>: Installing Docker");
        installDocker();
    });

/*
 * CONFIG Command
 *
 * Gets/sets/manipulates drupalci-related settings and environment variables.
 *
 * DrupalCI jobs are controlled via a hierarchy of configuration settings,
 * which define the behaviour of the platform while running DrupalCI jobs.
 * This hierarchy is defined as follows, which each level overriding the
 * previous:
 *
 *     1. Out-of-the-box DrupalCI defaults
 *     2. Local overrides defined in ~/.drupalci/config
 *     3. 'DRUPALCI_' namespaced environment variable overrides
 *     4. Test-specific overrides passed inside a DrupalCI test definition
 *
 * In addition to the out-of-the-box defaults, alternative config sets can be
 * defined within the ~/.drupalci/configs/ directory, with ~/.drupalci/config
 * simply being a symlink to the appropriate config file at any given time;
 * allowing end users to easily switch between multiple sets of configuration
 * overrides at any time.
 *
 * Usage: drupalci config [COMMAND] [OPTIONS]
 *
 * Commands:
 *
 *   list              Outputs a list of available configuration sets, which
 *                       can be passed to the 'load' command. Includes both
 *                       pre-defined and custom sets. (Output is the list of
 *                       files from ~/.drupalci/configs/*)
 *
 *   show <configset>  Outputs the testing default configuration overrides from
 *                       a given ~/.drupalci/configs/<configset> config set, or
 *                       if <configset> is not specified, the current
 *                       configuration (a combination of drupalci defaults,
 *                       config set overrides, and manual overrides established
 *                       via the 'set' command).

 *   load <configset>  Clears all drupalci namespaced environment variables and
 *                       establishes new values matching the combination of
 *                       drupalci defaults and overrides from the chosen config
 *                       set, as defined in ~/.drupalci/configs/<configset>.
 *
 *   save <configset>  Saves the current set of local testing default overrides
 *                       as a new configuration set with the provided name,
 *                       storing the result in ~/.drupalci/configs/<configset>.
 *
 *   set <setting=value>
 *                     Sets a default override for a particular configuration
 *                       setting, establishing the appropriate DrupalCI
 *                       namespaced environment variable
 *
 *   reset <setting>   Clears local default overrides by resetting the value of
 *                       the associated environment variable to the drupalci
 *                       defaults.  Also supports 'ALL'.
 *
 */
$console
    ->register('config')
    ->setDescription('Configure Environments')
    ->setCode(function (InputInterface $input, OutputInterface $output) use ($app) {
      $output->writeln("<info>INFO</info>: TODO: drupalci config code.");
    });

/*
 * BUILD Command
 *
 * Builds drupalci container images.
 *
 * Usage: drupalci build [OPTIONS]
 *
 * Options:
 * --dbtype=<dbtype>   Database type to use in the image.
 *                       Values: mariadb, mysql, pgsql, sqlite, or ALL.
 *                       Default: mariadb
 * --php_version=<phpver>
 *                     PHP Version to use in the image.
 *                       Values: 5.3, 5.4, 5.5, 5.6, or ALL.
 *                       Default: 5.4
 * --container_type    Type of container image to build
 *                       Values: db, web, ALL
 * --container_name    Name of a specific container image to build.
 *                       (TODO: do we use magic naming here?)
 */
$console
    ->register('build')
    ->setDescription('Build Containers')
    ->setCode(function (InputInterface $input, OutputInterface $output) use ($app) {
        $container['base'] = getContainers('base');
        $container['database'] = getContainers('database');
        $container['web'] = getContainers('web');

        var_dump($container);

    });

/*
 * TEST Command
 *
 * Used to execute a given test run.
 *
 * Usage: drupalci test [OPTIONS]
 *
 * Options:
 *   TBD
 */
$console
    ->register('test')
    ->setDescription('Running Tests');

return $console;
