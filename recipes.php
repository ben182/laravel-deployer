<?php

namespace Deployer;

task('artisan:clearAllCaches', function () {
    $aCommands = get('clearCachesCommands') ?: ['view:clear'];
    foreach ($aCommands as $sCommand) {
        artisan($sCommand, ['showOutput'])();
    }
});

task('artisan:cacheEverything', function () {
    $aCommands = get('cacheEverythingCommands') ?: [];
    foreach ($aCommands as $sCommand) {
        artisan($sCommand, ['showOutput'])();
    }
});

task('artisan:setVersion', function () {
    $git = get('bin/git');
    $sUrl = onlyLetters(run("cd {{release_path}} && $git config --get remote.origin.url"));
    $sTag = onlyLetters(run("cd {{release_path}} && $git describe --tags --abbrev=0"));
    $sHash = onlyLetters(run("cd {{release_path}} && $git log --pretty=\"%H\" -n1 HEAD"));

    artisan("deploy:infos \"$sUrl\" \"$sTag\" \"$sHash\"", ['showOutput'])();
});

task('artisan:deployBugsnag', function () {
    $git = get('bin/git');
    $sUrl = onlyLetters(run("cd {{release_path}} && $git config --get remote.origin.url"));
    $sTag = onlyLetters(run("cd {{release_path}} && $git describe --tags --abbrev=0"));
    $sHash = onlyLetters(run("cd {{release_path}} && $git log --pretty=\"%H\" -n1 HEAD"));

    artisan("deploy:infos \"$sUrl\" \"$sTag\" \"$sHash\" --bugsnag", ['showOutput'])();
});

function onlyLetters($string)
{
    return trim(preg_replace('/\s+/', ' ', $string));
}

task('artisan:envSync', function () {
    run("cd {{release_path}} && cp .env .env.backup");
    artisan('env:sync --no-interaction', ['showOutput'])();
});
task('artisan:backup', artisan('backup:run --only-db', ['showOutput', 'runInCurrent']));
