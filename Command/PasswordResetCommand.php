<?php

namespace MauticPlugin\PasswordResetBundle\Command;

use Mautic\CoreBundle\Factory\ModelFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PasswordResetCommand extends Command {

    public function __construct(
        protected UserPasswordEncoderInterface $userPasswordEncoder,
        protected ModelFactory $modelFactory,
    ) {
        parent::__construct();
    }

    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        $this->setName('mautic:reset:password')
            ->setDescription('Resets the password of the given user.')
            ->addArgument(
                'username',
                InputArgument::REQUIRED,
                'User name for which password needs to be reset.'
            )
            ->addArgument(
                'password',
                InputArgument::REQUIRED,
                'New password that needs to be reset.'
            );

        parent::configure();
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io  = new SymfonyStyle($input, $output);
        $user_name = $input->getArgument('username');
        $password = $input->getArgument('password');

        /** @var \Mautic\UserBundle\Model\UserModel $user_model */
        $user_model = $this->modelFactory->getModel('user');
        /** @var \Mautic\UserBundle\Entity\User $user */
        $user = $user_model->getRepository()->findByIdentifier($user_name);

        // If no user exists with given username / email.
        if (null === $user) {
            $io->error("No user exists with the username '$user_name'.");
            return 1;
        }

        $encodedPassword = $user_model->checkNewPassword(
            $user,
            $this->userPasswordEncoder,
            $password
        );

        $user->setPassword($encodedPassword);
        $user_model->saveEntity($user);

        $io->success("Password updated for the user '$user_name'.");
        return 0;
    }

}
