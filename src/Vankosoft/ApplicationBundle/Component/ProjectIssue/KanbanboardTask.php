<?php namespace Vankosoft\ApplicationBundle\Component\ProjectIssue;

final class KanbanboardTask
{
    /**
     * Issue Types
     */
    
    const ISSUE_TYPE_TASK   = 'task';
    const ISSUE_TYPE_BUG    = 'bug';
    const ISSUE_TYPE_STORY  = 'story';
    const ISSUE_TYPE_EPIC   = 'epic';
    
    const ISSUE_TYPES = [
        self::ISSUE_TYPE_TASK   => 'Task',
        self::ISSUE_TYPE_BUG    => 'Bug',
        self::ISSUE_TYPE_STORY  => 'Story',
        self::ISSUE_TYPE_EPIC   => 'Epic',
    ];
    
    /**
     * Task Priorities
     */
    
    const TASK_PRIORITY_HIGH    = 'high';
    const TASK_PRIORITY_MEDIUM  = 'medium';
    const TASK_PRIORITY_LOW     = 'low';
    
    const TASK_PRIORITIES = [
        self::TASK_PRIORITY_LOW     => 'Low',
        self::TASK_PRIORITY_MEDIUM  => 'Medium',
        self::TASK_PRIORITY_HIGH    => 'High',
    ];
    
    /**
     * Task Statuses
     */
    
    const TASK_STATUS_NEW           = 'new';
    const TASK_STATUS_INPROGRESS    = 'inprogress';
    const TASK_STATUS_COMPLETED     = 'completed';
    const TASK_STATUS_PENDING       = 'pending';
    
    const TASK_STATUSES = [
        self::TASK_STATUS_NEW           => 'New',
        self::TASK_STATUS_INPROGRESS    => 'Inprogress',
        self::TASK_STATUS_COMPLETED     => 'Completed',
        self::TASK_STATUS_PENDING       => 'Pending',
    ];
    
    /**
     * Board Member Designations
     */
    
    const BOARD_MEMBER_DESIGNATION_SYSTEM_ADMINISTRATOR = 'system_administrator';
    const BOARD_MEMBER_DESIGNATION_FULL_STACK_DEVELOPER = 'full_stack_developer';
    const BOARD_MEMBER_DESIGNATION_UI_UX_DESIGNER       = 'ui_ux_designer';
    const BOARD_MEMBER_DESIGNATION_WEB_DESIGNER         = 'web_designer';
    
    const BOARD_MEMBER_DESIGNATIONS = [
        self::BOARD_MEMBER_DESIGNATION_SYSTEM_ADMINISTRATOR => 'System Administrator',
        self::BOARD_MEMBER_DESIGNATION_FULL_STACK_DEVELOPER => 'Full Stack Developer',
        self::BOARD_MEMBER_DESIGNATION_UI_UX_DESIGNER       => 'UI/UX Designer',
        self::BOARD_MEMBER_DESIGNATION_UI_UX_DESIGNER       => 'Web Designer',
    ];
}
